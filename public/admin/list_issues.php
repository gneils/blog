<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to("/admin/login.php"); } ?>
<?php 
    // 1. the current page number ($current_page)
    $page = !empty($_GET['page'] ) ? (int)$_GET['page'] : 1;

    $safe_order_by = "id";
    $safe_sort = "ASC";
    $sortarrow = "&and;";
    $filter = "";
    $link = WEB_ROOT . "/admin/list_issues.php";
    $status_whitelist = array("open", "closed");
    $result = has_inclusion_in(filter_input(INPUT_GET, "s" ), $status_whitelist);
    if($result) {
        $filter = " WHERE curr_status = '" . filter_input(INPUT_GET, "s" ) . "' ";
    }
    if (!empty($_GET["ob"])) {
        $result = has_inclusion_in(filter_input(INPUT_GET, "ob" ), ["id","description","created","updated","status"]);
        if (!$result) {
            $errors["Status"] = "Status is invalid.";
        } else {
            $safe_order_by = filter_input(INPUT_GET, "ob" );
        }
    }
    if (!empty($_GET["s"])) {
        if ($_GET["s"] = "DESC"){
            $safe_sort = "DESC";
            $sortarrow = "&or;";
        }
    }
    $link_vars = "?ob=". $safe_order_by;
    if($safe_sort == "ASC") {
        $link_vars .= "&amp;s=DESC";
    }   
    

    // 2. records per page ($per_page)
    $per_page = $config['perpage'];
            
    // 3. total record count ($total_count)
    $total_count = Issue::count_all();
    
    $pagination = new Pagination($page, $per_page, $total_count);
    
        // Instead of finding all records, just find the records for this page
    $sql = "SELECT * FROM issues ";
    $sql .= $filter;
    $sql .= " ORDER BY " . $safe_order_by . " " . $safe_sort ." ";
    $sql .= " LIMIT {$per_page} ";
    $sql .= " OFFSET {$pagination->offset()} ";
    $issues = Issue::find_by_sql($sql);
    // echo $sql; // debug
?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Issues</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a href="<?php echo WEB_ROOT?>/admin/new_issue.php" class="btn btn-primary">Create a new issue</a>
    </div>
    <div class="col-md-4">
        <a href="<?php echo WEB_ROOT?>/admin/list_issues.php?s=open" class="btn btn-primary">Open Status Only</a>
    </div>
    <?php if ($pagination->total_pages() > 1) : ?>
    <div class="col-md-4"> 
        <nav id="pagination" style="text-align:right;">
            <ul class="pagination">
            <?php 
                if($pagination->has_previous_page()) {
                    echo "<li><a href =\"".WEB_ROOT."/admin/list_issues.php?page="
                            .$pagination->previous_page()
                            ."\" aria-label=\"Previous\">&laquo;</a></li>" ;
                }
                for($i=1; $i <= $pagination->total_pages(); $i++) {
                    $output = "<li ";
                    if($i == $page) {$output .= " class=\"active\"";}
                    $output .= ">";
                    if($i !== $page) {
                        $output .= "<a href=\"".WEB_ROOT;
                        $output .= "/admin/list_issues.php?page=".$i."\" ";
                        $output .= ">{$i}</a>";
                    } else {
                        $output .= "<span>{$i}</span>";
                    }
                    $output .= "</li>";
                    echo $output. PHP_EOL;
                }

                if($pagination->has_next_page()) {
                    echo "<li><a href =\"".WEB_ROOT."/admin/list_issues.php?page="
                            .$pagination->next_page()
                            ."\">&raquo;</a></li> ".PHP_EOL ;

                }
                if ($page > $pagination->total_pages()  ) {
                    echo "<a href =".WEB_ROOT."/list_issues.php class=\"btn btn-default\">Back</a>";
                } 
            ?>
            </ul>
        </nav>
    </div>
    <?php endif ?>   
</div>
<br />

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>Issues</caption>
            <tr>
                <th><a href="<?php echo WEB_ROOT?>/admin/list_issues.php?ob=id">ID<?php echo $sortarrow;?></a></th>
                <th><a href="<?php echo WEB_ROOT?>/admin/list_issues.php?ob=description">Description</th>
                <th><a href="<?php echo WEB_ROOT?>/admin/list_issues.php?ob=submited">Date Submitted</th>
                <th><a href="<?php echo WEB_ROOT?>/admin/list_issues.php?ob=updated">Last Updated</th>
                <th><a href="<?php echo WEB_ROOT?>/admin/list_issues.php?ob=status">Status</th>
                <th colspan="2">Action</th>
            </tr>
            <?php foreach($issues as $issue): ?>
                <tr>
                <td><?php echo h($issue->id); ?></td>
                <td><?php echo h($issue->description); ?></td>
                <td><?php echo date_to_text($issue->created); ?></td>
                <td><?php echo date_to_text($issue->updated); ?></td>
                <td><?php echo h($issue->curr_status); ?></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/edit_issue.php?id=<?php echo $issue->id?>">Edit</a></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/delete_issue.php?id=<?php echo $issue->id?>" onclick="return confirm ('Are you sure?');">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </table>        
    </div>
</div>


<?php include template_path("footer.php");?>
