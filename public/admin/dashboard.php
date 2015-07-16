<?php
require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php include template_path("header.php");?>
<?php include template_path("title.php");?>
<?php include template_path("top_menu.php");?>

<div class="row">
    <div class="col-md-12">
        <h2>Admin Dashboard</h2>
    </div>
</div>
    
<div class="row">
    <div class="col-md-12">
        <div id="page">
                <a href="manage_content.php" class="btn btn-default">Manage Web Site Content</a>
                <a href="manage_users.php" class="btn btn-default">Mange Users</a>
                <a href="logout.php" class="btn btn-default">logout</a>
        </div>
    </div>
</div>
<?php include template_path("footer.php");?>
