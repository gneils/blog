<?php
require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>


<?php
if(request_is_post()) {
    if(!csrf_token_is_valid()) {
        $message = "CSRF TOKEN MISSING OR MISMATCHED";
        $_SESSION["message"] = "Whoops!";
        redirect_to(WEB_ROOT."/404_error.php");
    }    
    $current_user = User::find_by_id($_POST["user"]);
} else {
    $options = array( 'options' => array('default'=> 0) ); 

    if(!filter_input(INPUT_GET,"user")) {
        $_SESSION["message"] = "Whoops! Please go back to the form.  Required Fiels Missing.";
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $is_number = has_number( filter_input(INPUT_GET,"user"));
    if(!$is_number ) {
        $_SESSION["message"] = "Wrong User ID.";
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $current_user = User::find_by_id($_GET["user"]);
    // $current_user = find_user_by_id($_GET["user"]);
}
?>
<?php 
    if (!$current_user) {
        // ID was missing or invalid or 
        // ID couldn't be found in the database
        $_SESSION["message"] = "User could not be found.";
        redirect_to(WEB_ROOT."/admin/manage_users.php"); 
    }
?>


<?php 
if (isset($_POST["submit"])) {
    // Process the form
    // validations
    $required_fields = array("user", "username", "password", "email");
    validate_presences($required_fields);
    $fields_with_max_lengths = array("username" => 30, "email" => 60);
    validate_max_lengths($fields_with_max_lengths);

    $fields_with_min_lengths = array("username" => 2, "password" => 8, "email" => 5);
    validate_min_lengths($fields_with_min_lengths);
    
    $email_fields = array("email");
    validate_emails($email_fields);

    if(empty($errors)){
        // perform update
        $safe_id = $database->escape_value(filter_input(INPUT_POST, "user"));
        $safe_username = $database->escape_value(filter_input(INPUT_POST, "username" ) ) ;
        $safe_last_name = $database->escape_value(filter_input(INPUT_POST, "last_name" ) ) ;
        $safe_first_name = $database->escape_value(filter_input(INPUT_POST, "first_name" ) ) ;
        $hashed_password  = password_encrypt( filter_input(INPUT_POST, "password" ))  ;
        $safe_email    = $database->escape_value(filter_input(INPUT_POST, "email" ) ) ;
        $query  = "UPDATE users SET ";
        $query .= "username = '{$safe_username}', ";
        $query .= "password = '{$hashed_password}', ";
        $query .= "last_name = '{$safe_last_name}', ";
        $query .= "first_name = '{$safe_first_name}', ";
        $query .= "email = '{$safe_email}' ";
        $query .= "WHERE id = {$safe_id} ";
        $query .= "LIMIT 1";

        //$result = mysqli_query($connection, $query);
        $result = $database->query( $query );
        if ($result && $database->affected_rows() >=0) {
            // Success
            $_SESSION["message"] = "User Info Updated.";
            redirect_to("manage_users.php?user=" . $safe_id );
        } else {
            // Failure
            $message = "Sorry, user was not updated:" .$database->affected_rows();
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
    <div class="col-md-10 col-md-offset-1"
         <h2>User: <?php echo h($current_user->username)?></h2></br></br></br>
            <form action="<?php echo WEB_ROOT?>/admin/edit_user.php" method="post">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="user" id="user" maxlength="30" value="<?php echo h($current_user->id);?>" /> 

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" readonly name="username" id="username" maxlength="30" class="form-control" value="<?php echo h($current_user->username);?>" /> 
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" name="first_name" id="last_name" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" name="last_name" id="last_name" maxlength="30" class="form-control" value="" /> 
            </div>

            <div class="form-group">
                <label for="email">email</label>
                <input type="text" name="email" maxlength="70" class="form-control" value="<?php echo s(h($current_user->email))?>" />
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update User" />
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/manage_users.php">Cancel</a>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/delete_user.php?user=<?php echo u($current_user->id)?>" onclick="return confirm ('Are you sure?');">Delete User</a>
        </form>
        <br />
      
        

    </div>
</div>
<br />
<br />

<?php include template_path("footer.php"); ?>