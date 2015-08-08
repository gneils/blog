<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php 
    if(empty($_GET['pid'])) {
        $session->message("No photograph ID was provided");
        redirect_to(WEB_ROOT.'/index.php');
    }
    
    $photo = Photograph::find_by_id($_GET['pid']);
    if(!$photo){
        $session->message("The photo could not be located");
        redirect_to(WEB_ROOT.'/index.php');
    }
    
    $comments = $photo->comments();
?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<p><a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/list_photos.php">Back</a></p>

<?php echo output_message($message); ?></p>

<div class="row">
    <div class="col-md-10">
        <h2>Comments on <?php echo $photo->filename; ?></h2>
    </div>
    <div class="col-md-2">
        <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" class="img-responsive" alt="<?php echo $photo->filename; ?>" style="border:1px solid #ccc;"/>
    </div>
</div>
    
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <?php foreach($comments as $comment):?>
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
                <div class="actions">
                    <a href="<?php echo WEB_ROOT?>/admin/delete_comment.php?cid=<?php echo $comment->id;?>" class="btn btn-warning btn-xs"> Delete Comment</a>
                </div>
            </div>
        <?php endforeach ?>
        <?php if(empty($comments)){echo "Be the frist to comment.";}?>
    </div>
</div>

<br />
<br />

<?php include template_path("footer.php"); ?>