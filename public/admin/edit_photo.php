<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php
if(request_is_post()) {
    if(!csrf_token_is_valid()) {
        $session->message("CSRF TOKEN MISSING OR MISMATCHED");
        redirect_to(WEB_ROOT."/404_error.php");
    }    
    $photo = Photograph::find_by_id($_POST["pid"]);
} else {
    $options = array( 'options' => array('default'=> 0) ); 

    if(!filter_input(INPUT_GET,"pid")) {
        $session->message("Whoops! Please go back to the form.  Required Fields Missing.");
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $is_number = has_number( filter_input(INPUT_GET,"pid"));
    if(!$is_number ) {
        $session->message("Wrong Photo ID.");
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $photo = Photograph::find_by_id($_GET["pid"]);
}

if (!$photo) {
    // ID was missing or invalid or 
    // ID couldn't be found in the database   
    $session->message("The photo could not be found.");
    redirect_to(WEB_ROOT."/admin/list_photos.php"); 
}

if (isset($_POST["submit"])) {
    // Process the form
    // validations
    $fields_with_max_lengths = array("caption" => 150);
    validate_max_lengths($fields_with_max_lengths);


    if(empty($errors)){
        // perform update
        $safe_id = $database->escape_value(filter_input(INPUT_POST, "pid"));
        $safe_caption = $database->escape_value(filter_input(INPUT_POST, "caption" ) ) ;
        $query  = "UPDATE photographs SET ";
        $query .= "caption = '{$safe_caption}' ";
        $query .= "WHERE id = {$safe_id} ";
        $query .= "LIMIT 1";

        //$result = mysqli_query($connection, $query);
        $result = $database->query( $query );
        
        if ($result && $database->affected_rows() >=0) {
            // Success
            $session->message("The photo info was updated.");
            redirect_to(WEB_ROOT."/admin/list_photos.php?");
        } else {
            // Failure
            $message = "Sorry, user was not updated:";
        }
    } else {
        // errors fall through to form below
    }
}
?>

<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<?php // $message is just a variable, doesn't use the SESSION
    if (!empty($message)) {echo "<div class=\"message\">" . h($message) . "</div>";}
?>
<?php if(isset($errors)) {echo form_errors($errors);}?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class ="text-center">
        <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" width="320" alt="<?php echo $photo->filename; ?>"/>
        </div>
        <form action="<?php echo WEB_ROOT?>/admin/edit_photo.php" method="post">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="pid" id="pid" maxlength="30" value="<?php echo h($photo->id);?>" /> 
            <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" name="caption" id="caption" maxlength="30" class="form-control" value="<?php echo h($photo->caption);?> "/> 
            </div>
            <button type="submit" name="submit" value="edit-photo" class="btn btn-primary">Save</button>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/list_photos.php">Cancel</a>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/delete_photo.php?pid=<?php echo u($photo->id)?>" onclick="return confirm ('Are you sure?');">Delete photo</a>
        </form>
        <br />
    </div>
</div>
<br />
<br />

<?php include template_path("footer.php"); ?>