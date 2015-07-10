<?php require_once ("../private/initialize.php");?>
<?php $photo_objects = Photograph::find_all();?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Photographs</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php foreach($photo_objects as $photo): ?>
            <a href="<?php echo WEB_ROOT."/photo.php?pid=".($photo->id);?>">
                <div class="drop-shadow perspective">
                    <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" width="100" alt="<?php echo $photo->filename; ?>"/>
                    <?php echo $photo->caption; ?>
                </div>
            </a>
        <?php endforeach;?>
    </div>
</div>

<?php include template_path("footer.php");?>
