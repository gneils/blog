<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php $photo_objects = Photograph::find_all();?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-6 col-sm-offset-3">
        <h2>Sample Modal</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-offset-3">
        <a href="<?php echo WEB_ROOT?>/admin/photo_upload.php" class="btn btn-primary btn-lg">Upload a new photograph</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<div class="row">
    <div class="col-xs-12" style="height:20px;"></div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php  include template_path("modal_sample.php");?> 
        
    </div>
</div>
<?php include template_path("footer.php");?>
