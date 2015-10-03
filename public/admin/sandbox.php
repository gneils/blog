<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<div class="row">
    <div class="col-md-12">
        <h2>Welcome to the Sandbox.  Test & develop code here.</h2>
    </div>
</div>
<?php if(isset($message)) { ?>
<div class="row">
    <div class="col-md-12">
        <h3><?php //echo output_message($message); ?></h3> 
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <h3>Place you code below:</h3> 
<?php 
    if(isset($_GET["x"])) {
        echo "X was set to: " . $_GET["x"] . "<hr>";
        echo "After sanitized: " .     $email = filter_input(INPUT_GET, "x", FILTER_SANITIZE_EMAIL);
    }
?>
    </div>
</div>



<?php include template_path("footer.php");?>
