<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<div class="row">
    <div class="col-md-12">
        <p>Welcome to the admin area.  We  hope to inspire you to write!</p>
        <p>This request was at: <?php echo $session->current_request_time;?></p>
        <p>Your last request was at: <?php echo $session->last_request_time;?></p>
        <p>Your last request was <?php echo intval($session->time_delta/60);?> minute ago.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<?php include template_path("footer.php");?>
