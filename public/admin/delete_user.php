<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>

<?php 
    // THIS NEEDS TO BE CLEANED BEFORE USING!
    $current_user = User::find_by_id($_GET["user"]);
    if (!$current_user) {
        // ID was missing or invalid or 
        // ID couldn't be found in the database
        $_SESSION["message"] = "User could not be found.";
        redirect_to(WEB_ROOT."/admin/manage_users.php"); 
    }  
   
    $id = $current_user->id;
    $query = "DELETE FROM users WHERE id = {$id} LIMIT 1";
    $result = $database->query( $query );
    
    
    $result = $database->query( $query );
    if ($result && $database->affected_rows() >=0) {
        // Success
        $_SESSION["message"] = "User Info Deleted.";
        redirect_to("manage_users.php");
    } else {
        $_SESSION["message"] = "User deletion failed.";
        redirect_to("manage_users.php?user={$id}");
    }
?>
    