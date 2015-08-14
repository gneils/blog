<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>

<?php 
    // must have an id
    if(empty($_GET['id'])) {
        $session->message("No Issue ID was provided");
        redirect_to(WEB_ROOT.'/admin/list_issues.php');
    }
    
    $issue = Issue::find_by_id($_GET['id']);

    if($issue && $issue->delete()) {
        
        
        $session->message("The issue {$issue->id} was deleted");
        redirect_to(WEB_ROOT.'/admin/list_issues.php');
    } else {
        $session->message("The issue {$issue->id} could not be deleted.");
        redirect_to(WEB_ROOT.'/admin/list_issues.php');
    }
?>
<?php if(isset($database)) {$database->close_connection();}?>
    