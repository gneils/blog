<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("/admin/login.php"); } ?>

<?php 
    // must have an id

    if(empty($_GET['cid'])) {
        $session->message("No comment ID was provided");
        redirect_to(WEB_ROOT.'/admin/index.php');
    }
    
    $comment = Comment::find_by_id($_GET['cid']);
    if($comment && $comment->delete()) {
        $session->message("The comment was deleted");
        redirect_to(WEB_ROOT.'/admin/comments.php?pid='.$comment->photograph_id);
    } else {
        $session->message("The commnet could not be deleted.");
        redirect_to(WEB_ROOT.'/admin/list_photos.php');
    }
?>
<?php if(isset($database)) {$database->close_connection();}?>
    