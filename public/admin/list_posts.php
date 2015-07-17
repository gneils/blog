<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php 
    // 1. the current page number ($current_page)
    $page = !empty($_GET['page'] ) ? (int)$_GET['page'] : 1;

    // 2. records per page ($per_page)
    $per_page = 10;
            
    // 3. total record count ($total_count)
    $total_count = Post::count_all();
    
    $pagination = new Pagination($page, $per_page, $total_count);
    
        // Instead of finding all records, just find the records for this page
    $sql = "SELECT * FROM posts ";
    $sql .= "LIMIT {$per_page} ";
    $sql .= "OFFSET {$pagination->offset()}";
    $posts = Post::find_by_sql($sql);
    
    ?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Posts</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
<a href="<?php echo WEB_ROOT?>/admin/create_post.php" class="btn btn-primary">Create a new post</a>
    </div>
</div>
<br />

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>Posts</caption>
            <tr><th>Person</th><th>Date</th><th>Description</th><th>Author</th><th>Tags</th><th>Rating</th><th colspan="2">Action</th></tr>
            <?php foreach($posts as $post): ?>
                <tr>
                <td><?php echo $post->person; ?></td>
                <td><?php echo date_to_text($post->event_date); ?></td>
                <td><?php echo $post->description; ?></td>
                <td><?php echo $post->author?></td>
                <td><?php echo $post->tags?></td>
                <td><?php echo $post->rating?></td>               
                <td><a href="<?php echo WEB_ROOT?>/admin/edit_post.php?pid=<?php echo $post->id?>">Edit</a></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/delete_post.php?pid=<?php echo $post->id?>" onclick="return confirm ('Are you sure?');">Delete</a></td>
            <?php endforeach; ?>
        </table>        
    </div>
</div>
<?php if ($pagination->total_pages() > 1) : ?>
    <div class="row" style="border:1px solid red;">
        <div class="col-md-12">
            <nav id="pagination">
                <ul class="pagination">
                <?php 
                    if($pagination->has_previous_page()) {
                        echo "<li><a href =\"".WEB_ROOT."/admin/list_posts.php?page="
                                .$pagination->previous_page()
                                ."\" aria-label=\"Previous\">&laquo;</a></li>" ;
                    }
                    for($i=1; $i <= $pagination->total_pages(); $i++) {
                        $output = "<li ";
                        if($i == $page) {$output .= " class=\"active\"";}
                        $output .= ">";
                        if($i !== $page) {
                            $output .= "<a href=\"".WEB_ROOT;
                            $output .= "/admin/list_posts.php?page=".$i."\" ";
                            $output .= ">{$i}</a>";
                        } else {
                            $output .= "<span>{$i}</span>";
                        }
                        $output .= "</li>";
                        echo $output. PHP_EOL;
                    }

                    if($pagination->has_next_page()) {
                        echo "<li><a href =\"".WEB_ROOT."/admin/list_posts.php?page="
                                .$pagination->next_page()
                                ."\">&raquo;</a></li> ".PHP_EOL ;

                    }
                    if ($page > $pagination->total_pages()  ) {
                        echo "<a href =".WEB_ROOT."/list_posts.php class=\"btn btn-default\">Back</a>";
                    } 
                ?>
                </ul>
            </nav>
        </div>
    </div>
<?php endif ?>

<?php include template_path("footer.php");?>