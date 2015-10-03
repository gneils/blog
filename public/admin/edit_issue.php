<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php
if(request_is_post()) {
    if(!csrf_token_is_valid()) {
        $message = "CSRF TOKEN MISSING OR MISMATCHED";
        $_SESSION["message"] = "Whoops!";
        redirect_to(WEB_ROOT."/404_error.php");
    }    
    $current_issue = Issue::find_by_id($_POST["id"]);
} else {
    $options = array( 'options' => array('default'=> 0) ); 

    if(!filter_input(INPUT_GET,"id")) {
        $_SESSION["message"] = "Whoops! Please go back to the form.  Required Fields Missing.";
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $is_number = has_number( filter_input(INPUT_GET,"id"));
    if(!$is_number ) {
        $_SESSION["message"] = "Wrong Issue ID.";
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $current_issue = Issue::find_by_id($_GET["id"]);
}
?>
<?php 
    if (!$current_issue) {
        // ID was missing or invalid or 
        // ID couldn't be found in the database
        $_SESSION["message"] = "Issue could not be found.";
        redirect_to(WEB_ROOT."/admin/list_issues.php"); 
    }
?>

<?php 
if (isset($_POST["submit"])) {
    // Process the form
    // validations
    $required_fields = array("description");
    validate_presences($required_fields);
    $fields_with_max_lengths = array("description" => 150);
    validate_max_lengths($fields_with_max_lengths);

    $fields_with_min_lengths = array("description" => 2);
    validate_min_lengths($fields_with_min_lengths);
    
    $valid_stats_options = ["Open","Closed"];
            
    $result = has_inclusion_in(filter_input(INPUT_POST, "status" ), $valid_stats_options);
    if (!$result) {
        $errors["Status"] = "Status is invalid.";
    }
    
    if(empty($errors)){
        // perform update
        $safe_id = $database->escape_value(filter_input(INPUT_POST, "id"));
        $safe_description = $database->escape_value(s(filter_input(INPUT_POST, "description" )) ) ;
        $safe_status = $database->escape_value(s(filter_input(INPUT_POST, "status" ) ) ) ;
        $safe_resolution = $database->escape_value(s(filter_input(INPUT_POST, "resolution" ) ) ) ;
        $query  = "UPDATE issues SET ";
        $query .= "description = '{$safe_description}', ";
        $query .= "curr_status = '{$safe_status}', ";
        $query .= "resolution = '{$safe_resolution}' ";
        $query .= "WHERE id = {$safe_id} ";
        $query .= "LIMIT 1";

        //$result = mysqli_query($connection, $query);
        $result = $database->query( $query );
        if ($result && $database->affected_rows() >=0) {
            // Success
            $_SESSION["message"] = "Issue Info Updated.";
            redirect_to(WEB_ROOT."/admin/list_issues.php?id=" . $safe_id );
        } else {
            // Failure
            $message = "Sorry, issue was not updated:" .$database->affected_rows();
        }
    } else {
        // errors fall through to form below
    }
} // end if (isset($_POST["submit"])) 
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
            <form action="<?php echo WEB_ROOT?>/admin/edit_issue.php" method="post">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="id" id="id" value="<?php echo h($current_issue->id);?>" /> 
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"  class="form-control" rows="5"><?php echo h($current_issue->description);?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control"> 
                    <option value="Open" <?php if($current_issue->curr_status == "Open") {echo "selected";}?>>Open</option>
                    <option value="Closed" <?php if($current_issue->curr_status == "Closed") {echo "selected";}?>>Closed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="resolution">Resolution</label>
                <textarea name="resolution" id="resolution"  class="form-control" rows="5"><?php echo h($current_issue->resolution);?></textarea>
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update Issue" />
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/list_issues.php">Cancel</a>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/delete_issue.php?id=<?php echo u($current_issue->id)?>" onclick="return confirm ('Are you sure?');">Delete Issue</a>
        </form>
        <br />
    </div>
</div>
<br />
<br />

<?php include template_path("footer.php"); ?>