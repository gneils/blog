<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>

<?php 
    // must have an id
    if(empty($_GET['pid'])) {
        $session->message("No Post ID was provided");
        redirect_to(WEB_ROOT.'/index.php');
    }
    
    $post = Post::find_by_id($_GET['pid']);
    if($post && $post->destroy()) {
        $session->message("The post {$post->filename} was deleted");
        redirect_to(WEB_ROOT.'/admin/list_photos.php');
    } else {
        $session->message("The post {$post->filename} could not be deleted.");
        redirect_to(WEB_ROOT.'/admin/list_posts.php');
    }
?>
<?php if(isset($database)) {$database->close_connection();}?>
    