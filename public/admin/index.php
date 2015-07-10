<?php
require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <p>Welcome to the admin area.  We  hope to inspire you to write!</p>
    </div>
</div>
<?php include template_path("footer.php");?>
