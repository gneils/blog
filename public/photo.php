<?php require_once ("../private/initialize.php");?>
<?php $photo = Photograph::find_by_id($_GET['pid']);?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2><?php echo $photo->caption; ?></h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="drop-shadow perspective">
            <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" class="img-responsive" alt="<?php echo $photo->filename; ?>"/>
            <?php echo $photo->caption; ?>
        </div>
    </div>
</div>

<?php include template_path("footer.php");?>