<?php
require_once ("../../private/initialize.php");

if($session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/index.php");}
// Remember to give your form's sumit tag a name="submit" attribute!

if(isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    die_on_csrf_token_failure();
    
// Check database to see if username/password exists.
    $found_user = User::authenticate($username, $password);
    
    if($found_user) {
        $session->login($found_user);
        logger($level = "Login", $msg = $found_user->username . " logged in.");
        $_SESSION["admin_id"] = $found_user->id;
        $_SESSION["username"] = $found_user->username;
        redirect_to(WEB_ROOT."/admin/index.php");
    } else {
        // username/password combo was not found in the database
        $message = "Username/password combination is incorrect.";
    }
    
} else { // Form has not been submited
    $username = "";
    $password = "";
    $message = "";
}
?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<div class="row">
    <div class="col-md-offset-4 col-md-4">
    </div>
</div>
<?php if (isset($session->message)) {echo $session->message;}?>
<?php echo output_message($message); ?>

<div class="row">
    <div class="col-md-offset-4 col-md-4 well well-lg">
        <h4>Login</h4>  
        <form action="<?php echo WEB_ROOT."/admin/"?>login.php" method="post">
            <?php echo csrf_token_tag()?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" maxlength="30" class="form-control" value="<?php echo h($username);?>" /> 
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" maxlength="30" class="form-control" value="" /> 
            </div>
            <input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg btn-block"/>
        </form>
    </div>
</div>

<?php include template_path("footer.php");?>
