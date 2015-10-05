<?php require_once ("../../private/initialize.php"); ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php
    $current_user = User::find_by_id($session->user_id);
    if(!isset($session->user_id)) {
        $_SESSION["message"] = "Whoops! There was an error.";
        redirect_to(WEB_ROOT."/404_error.php");
    }
    
    if(request_is_post()) {
        if(!csrf_token_is_valid()) {
            $message = "CSRF TOKEN MISSING OR MISMATCHED";
            $_SESSION["message"] = "Whoops!";
            redirect_to(WEB_ROOT."/404_error.php");
        }    
        $required_fields = array("user", "old_password", "new_password", "repeat_password");
        validate_presences($required_fields);
        $fields_with_max_lengths = array("old_password" => 30, "new_password" => 30, "repeat_password" => 30);
        validate_max_lengths($fields_with_max_lengths);

        $fields_with_min_lengths = array("new_password" => 8);
        validate_min_lengths($fields_with_min_lengths);

        // Compare old password to stored password
        $old_password = filter_input(INPUT_POST,"old_password");
        if ( !password_check( $old_password, $current_user->password )) {
            $errors["old_password"] = "Please check your old password.";
        } 
        
        if(empty($errors)){
            // perform update
            
            $safe_id = $database->escape_value(filter_input(INPUT_POST, "user", FILTER_SANITIZE_NUMBER_INT));
            $hashed_password  = password_encrypt( (filter_input(INPUT_POST, "new_password" )) )  ;

            $query  = "UPDATE users SET ";
            $query .= "password = '{$hashed_password}' ";
            $query .= "WHERE id = {$safe_id} ";
            $query .= "LIMIT 1";

            //$result = mysqli_query($connection, $query);
            $result = $database->query( $query );
            if ($result && $database->affected_rows() >=0) {
                // Success
                $_SESSION["message"] = "Your password was updated.";
                redirect_to(WEB_ROOT."/admin/manage_users.php?user=" . $safe_id );
            } else {
                // Failure
                $message = "Sorry, your password was not updated:" .$database->affected_rows();
            }
        } else {
            // errors fall through to form below
        }
    } // end if (request_is_post)

 ?>

<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<?php // $message is just a variable, doesn't use the SESSION
    if (!empty($message)) {echo "<div class=\"message\">" . h($message) . "</div>";}
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1"
         <h2>User: <?php echo h($current_user->username)?></h2></br></br></br>
    </div>
</div>
<?php if(isset($errors)) {echo form_errors($errors);}?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?php echo WEB_ROOT?>/admin/update_password.php" method="post">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="user" id="user" maxlength="30" value="<?php echo h($current_user->id);?>" /> 

            <div class="form-group">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" id="old_password" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="repeat_password">Repeat Password</label>
                <input type="password" name="repeat_password" id="repeat_password" maxlength="30" class="form-control" value="" /> 
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update Password" />
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/manage_users.php">Cancel</a>
        </form>
        <br />
    </div>
</div>
<?php include template_path("footer.php"); ?>