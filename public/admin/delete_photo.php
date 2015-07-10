<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>

<?php 
    // must have an id
    if(empty($_GET['pid'])) {
        $session->message("No photograph ID was provided");
        redirect_to(WEB_ROOT.'/index.php');
    }
    
    $photo = Photograph::find_by_id($_GET['pid']);
    if($photo && $photo->destroy()) {
        $session->message("The photo {$photo->filename} was deleted");
        redirect_to(WEB_ROOT.'/admin/list_photos.php');
    } else {
        $session->message("The photo {$photo->filename} could not be deleted.");
        redirect_to(WEB_ROOT.'/admin/list_photos.php');
    }
?>
<?php if(isset($database)) {$database->close_connection();}?>
    