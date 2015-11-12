<?php require_once ("../private/initialize.php");?>
<?php 
    // 1. the current page number ($current_page)
    $page = !empty($_GET['page'] ) ? (int)$_GET['page'] : 1;

    // 2. records per page ($per_page)
    $per_page = 1;
            
    // 3. total record count ($total_count)
    $total_count = Photograph::count_all();
    
    $pagination = new Pagination($page, $per_page, $total_count);
    
    // Instead of finding all records, just find the records for this page
    $sql = "SELECT * FROM photographs ";
    $sql .= "LIMIT {$per_page} ";
    $sql .= "OFFSET {$pagination->offset()}";
    $photos = Photograph::find_by_sql($sql);
    
    // Need to add ?page=$page to all links we want to 
    // maintain the current page (or store $page in $session)
    
    $sql = "SELECT * FROM posts";
    $sql .= " ORDER BY RAND()";
    $sql .= " LIMIT 1 ";
    $post = Post::find_by_sql($sql);
    $post = array_shift($post);
?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
include template_path("session_message.php");
?>

<div class="row">
    <div class="col-md-12">
<?php  include template_path("carousel.php");?>      
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h2>One Random Photo</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php foreach($photos as $photo): ?>
            <a href="<?php echo WEB_ROOT."/photo.php?pid=".($photo->id);?>">
                <div class="drop-shadow perspective">
                    <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" height="100" alt="<?php echo $photo->filename; ?>"/>
                    <br><br>
                    <?php echo $photo->caption; ?>
                </div>
            </a>
        <?php endforeach;?>
    </div>
</div>
<?php if ($pagination->total_pages() > 1) : ?>
    <div class="row">
        <div class="col-md-12">
            <nav id="pagination">
                <ul class="pagination">
                <?php 
                    if($pagination->has_previous_page()) {
                        echo "<li><a href =\"".WEB_ROOT."/index.php?page="
                                .$pagination->previous_page()
                                ."\" aria-label=\"Previous\">&laquo;</a></li>" ;
                    }
                    for($i=1; $i <= $pagination->total_pages(); $i++) {
                        $output = "<li ";
                        if($i == $page) {$output .= " class=\"active\"";}
                        $output .= ">";
                        if($i !== $page) {
                            $output .= "<a href=\"".WEB_ROOT;
                            $output .= "/index.php?page=".$i."\" ";
                            $output .= ">{$i}</a>";
                        } else {
                            $output .= "<span>{$i}</span>";
                        }
                        $output .= "</li>";
                        echo $output. PHP_EOL;
                    }

                    if($pagination->has_next_page()) {
                        echo "<li><a href =\"".WEB_ROOT."/index.php?page="
                                .$pagination->next_page()
                                ."\">&raquo;</a></li> ".PHP_EOL ;

                    }
                    if ($page > $pagination->total_pages()  ) {
                        echo "<a href =".WEB_ROOT."/index.php class=\"btn btn-default\">Back</a>";
                    } 
                ?>
                </ul>
            </nav>
        </div>
    </div>
<?php endif ?>
                        
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>Random Post of the day</caption>
            <tr><th>Person</th><th>Date</th><th>Description</th><th>Author</th><th>Tags</th><th>Rating</th></tr>
                <tr>
                <td><?php echo h($post->person); ?></td>
                <td><?php echo date_to_text($post->event_date); ?></td>
                <td><?php echo h($post->description); ?></td>
                <td><?php echo h($post->author)?></td>
                <td><?php echo h($post->tags)?></td>
                <td><?php echo h($post->rating)?></td>               
        </table>        
    </div>
</div>
<?php include template_path("footer.php");?>
