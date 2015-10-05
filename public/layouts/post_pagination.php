<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>

<?php if(!isset($link_page)) {$link_page = "list_posts";}?>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <caption>Posts</caption>
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
    <?php if ($pagination->total_pages() > 1) : ?>
        <div class="row" style="border:1px solid red;">
            <div class="col-md-4">
                <nav id="pagination">
                    <ul class="pagination">
                    <?php 
                        if($pagination->has_previous_page()) {
                            echo "<li><a href =\"".WEB_ROOT."/admin/{$link_page}.php?page="
                                    .$pagination->previous_page()
                                    ."\" aria-label=\"Previous\">&laquo;</a></li>" ;
                        }
                        for($i= $page-3 ; $i <= $page + 3; $i++) {
                            $output = "<li ";
                            if($i == $page) {$output .= " class=\"active\"";}
                            $output .= ">";
                            if($i !== $page) {
                                $output .= "<a href=\"".WEB_ROOT;
                                $output .= "/admin/{$link_page}.php?page=".$i."\" ";
                                $output .= ">{$i}</a>";
                            } else {
                                $output .= "<span>{$i}</span>";
                            }
                            $output .= "</li>";
                            echo $output. PHP_EOL;
                        }

                        if($pagination->has_next_page()) {
                            echo "<li><a href =\"".WEB_ROOT."/admin/{$link_page}.php?page="
                                    .$pagination->next_page()
                                    ."\">&raquo;</a></li> ".PHP_EOL ;
                        }
                        if ($page > $pagination->total_pages()  ) {
                            echo "<a href =".WEB_ROOT."/{$link_page}.php class=\"btn btn-default\">Back</a>";
                        } 
                    ?>
                    </ul>
                </nav>
            </div>
        </div>
    <?php endif ?>