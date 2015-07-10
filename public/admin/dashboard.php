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
            <ul>
                <li><a href="manage_content.php">Manage Web Site Content</a></li>
                <li><a href="manage_users.php">Mange Users</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</div>
<?php include template_path("footer.php");?>
