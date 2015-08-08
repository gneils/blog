<?php
require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); }
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
                <a href="<?php echo WEB_ROOT?>/admin/list_photos.php" class="btn btn-default">List Photos</a>
                <a href="<?php echo WEB_ROOT?>/admin/list_posts.php" class="btn btn-default">List Posts</a>
                <a href="<?php echo WEB_ROOT?>/admin/manage_users.php" class="btn btn-default">Mange Users</a>
                <a href="<?php echo WEB_ROOT?>/admin/logout.php" class="btn btn-default">logout</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        
    </div>
</div>
<?php include template_path("footer.php");?>
