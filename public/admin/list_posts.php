<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php 
    // 1. the current page number ($current_page)
    $page = !empty($_GET['page'] ) ? (int)$_GET['page'] : 1;

    // 2. records per page ($per_page)
    $per_page = 15;
            
    // 3. total record count ($total_count)
    $total_count = Post::count_all();
    
    $pagination = new Pagination($page, $per_page, $total_count);
    
        // Instead of finding all records, just find the records for this page
    $sql = "SELECT * FROM posts ";
    $sql .= "ORDER BY event_date DESC ";
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
    <div class="col-md-6">
        <a href="<?php echo WEB_ROOT?>/admin/new_post.php" class="btn btn-primary">Create a new post</a>
    </div>
    <?php if ($pagination->total_pages() > 1) : ?>
    <div class="col-md-6">
        <nav id="pagination">
            <ul class="pagination">
            <?php 
                if($pagination->has_rewind_page()) {
                    echo "<li><a href =\"".WEB_ROOT."/admin/list_posts.php?page="
                            .$pagination->rewind_page()
                            ."\" aria-label=\"Previous\">&laquo;&laquo;</a></li>" ;
                }
                if($pagination->has_previous_page()) {
                    echo "<li><a href =\"".WEB_ROOT."/admin/list_posts.php?page="
                            .$pagination->previous_page()
                            ."\" aria-label=\"Previous\">&laquo;</a></li>" ;
                }
                for($i= $pagination->start_page() ; $i <= $pagination->end_page(); $i++) {
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
                if($pagination->has_fast_forward_page()) {
                    echo "<li><a href =\"".WEB_ROOT."/admin/list_posts.php?page="
                            .$pagination->fast_forward_page()
                            ."\">&raquo;&raquo;</a></li> ".PHP_EOL ;

                }
                if ($page > $pagination->total_pages()  ) {
                    echo "<a href =".WEB_ROOT."/list_posts.php class=\"btn btn-default\">Back</a>";
                } 
            ?>
            </ul>
        </nav>
    </div>
<?php endif ?>
</div>

<div class="row">
    <div class="col-xs-12" style="height:50px;"></div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <tr><th>Person</th>
                <th>Date</th>
                <th>Title</th>
                <th>Description</th>
                <th>Author</th>
                <th>Tags</th>
                <th>Rating</th>
                <th colspan="2">Action</th>
            </tr>
            <?php foreach($posts as $post): ?>
                <tr>
                <td><?php echo h($post->person); ?></td>
                <td><?php echo date_to_text($post->event_date); ?></td>
                <td><?php echo h($post->title); ?></td>
                <td><?php echo nl2br(h($post->description)); ?></td>
                <td><?php echo h($post->author)?></td>
                <td><?php echo h($post->tags)?></td>
                <td><?php echo h($post->rating)?></td>               
                <td><a href="<?php echo WEB_ROOT?>/admin/edit_post.php?pid=<?php echo $post->id?>">Edit</a></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/delete_post.php?pid=<?php echo $post->id?>" onclick="return confirm ('Are you sure?');">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </table>        
    </div>
</div>
<?php include template_path("footer.php");?>
