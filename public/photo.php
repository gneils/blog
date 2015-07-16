<?php require_once ("../private/initialize.php");?>
<?php 
    if(empty($_GET['pid'])) {
        $session->message("No photograph ID was provided");
        redirect_to('index.php');
    }
    
    $photo = Photograph::find_by_id($_GET['pid']);
    if(!$photo){
        $session->message("The photo could not be located");
        redirect_to('index.php');
    }
    
    if(isset($_POST['submit'])) {
        $author = s(trim($_POST['author']));
        $body = s(trim($_POST['body']));
        
        $new_comment = Comment::make($photo->id, $author, $body);
        
        if($new_comment && $new_comment->save()) {
            // comment saved
            // No message needed; seeing the comment is proof enough.              
           $session->message("Your comment was saved.");
            redirect_to(WEB_ROOT."/photo.php?pid=".$photo->id);
        } else {
            // failed
            $message = "There was an error that prevented the comment from being saved.";
        }
    } else {
        $author = "";
        $body = "";
    }
    
    $comments = $photo->comments();
    
?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
    </div>
</div>
<div class="row">
    <div class="col-md-offset-3 col-md-6 ">
        <div class="drop-shadow perspective">
            <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" class="img-responsive" alt="<?php echo $photo->filename; ?>"/>
            <h2 class="text-center"><?php echo $photo->caption; ?></h2> 
        </div>
    </div>
</div>

<?php // $message is just a variable, doesn't use the SESSION
    if (!empty($message)) {echo "<div class=\"message\">" . h($message) . "</div>";}
    if(isset($errors)) {echo form_errors($errors);}
?>


<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <?php 
            if(empty($comments)){
                echo "<h3>Be the frist to comment.</h3>";
            } else {
                echo "<h3>New Comment</h2>";
            }
        ?>
        <form action="<?php echo WEB_ROOT?>/photo.php?pid=<?php echo $photo->id;?>" method="post">
            <?php echo csrf_token_tag(); ?>
            <div class="form-group">
                <label for="author">Your Name</label>
                <input type="text" name="author" id="author" maxlength="30" class="form-control" value="<?php echo $author;?>" /> 
            </div>
            <div class="form-group">
                <label for="body">Your Comment</label>
                <textarea name="body" id="body" maxlength="600" class="form-control"><?php echo $body;?></textarea>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Submit Comment" />
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/index.php">Cancel</a>
        </form>
        <br />
    </div>
</div>

<?php if(!empty($comments)){ ?>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?php echo "<h2>Past Comments</h2>";
                foreach($comments as $comment):?>
                    <div class="comment">
                    <div class="author">
                        <?php echo h($comment->author);?>: 
                    </div>
                    <div class="body">
                        <?php echo strip_tags($comment->body, '<strong><em><p>');?>
                    </div>
                    <div class="meta-info">
                        <?php echo datetime_to_text($comment->created);?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php } ?>

<?php include template_path("footer.php");?>