<?php require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to("login.php"); }
?>
<?php $photo_objects = Photograph::find_all();?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Photo List</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
<a href="<?php echo WEB_ROOT?>/admin/photo_upload.php">Upload a new photograph</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>List of Photos</caption>
            <tr><th>Image</th><th>Name</th><th>Caption</th><th>Type</th><th>size</th></tr>
            <?php foreach($photo_objects as $photo): ?>
                <tr>
                <td><img src="<?php echo h($photo->image_path()); ?>" width="100" alt="<?php echo $photo->filename; ?>"/></td>
                <td><?php echo $photo->filename; ?></td>
                <td><?php echo $photo->caption; ?></td>
                <td><?php echo $photo->type; ?></td>
                <td><?php echo $photo->size_as_text()?></td>
            <?php endforeach; ?>
        </table>        
    </div>
</div>

<?php include template_path("footer.php");?>