<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-offset-2 col-md-6">
        <?php echo $session->message(); ?>
        <?php echo $session->errors(); ?>
        <h2>Create a new user</h2>
        <form action="create_user.php" method="post" class="form-horizontal">
            <?php echo csrf_token_tag(); ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" maxlength="30" class="form-control" value="" /> 
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
                <label for="password">Password</label>
                <input type="password" name="password" id="password" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input type="text" name="email" id="email" maxlength="60" class="form-control" value="" /> 
            </div>
            <input type="submit" name="submit" value="Create User" class="btn btn-primary"/>
            <a href="<?php echo WEB_ROOT?>/admin/manage_users.php" class="btn btn-default">Cancel</a>
        </form>
        <br />
        <br />
        <br />
        <br />
        <br />
    </div>
</div>

<?php include template_path("footer.php");?>
