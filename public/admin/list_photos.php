<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
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
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
<a href="<?php echo WEB_ROOT?>/admin/photo_upload.php" class="btn btn-primary">Upload a new photograph</a>
    </div>
</div>
<div class="row">
    <div class="col-xs-12" style="height:20px;"></div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <tr><th>Image</th><th>Name</th><th>Caption</th><th>Type</th><th>size</th><th>Comments</th><th colspan="2">Action</th></tr>
            <?php foreach($photo_objects as $photo): ?>
                <tr>
                    <td>
                        <a href="<?php echo WEB_ROOT?>/admin/edit_photo.php?pid=<?php echo $photo->id?>">
                            <img src="<?php echo WEB_ROOT."/".h($photo->image_path()); ?>" width="100" alt="<?php echo $photo->filename; ?>"/>
                        </a>
                    </td>
                <td><?php echo $photo->filename; ?></td>
                <td><?php echo $photo->caption; ?></td>
                <td><?php echo $photo->type; ?></td>
                <td><?php echo $photo->size_as_text()?></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/comments.php?pid=<?php echo $photo->id?>">
                    <?php echo count($photo->comments())?>
                    </a>
                </td>
                
                <td><a href="<?php echo WEB_ROOT?>/admin/edit_photo.php?pid=<?php echo $photo->id?>">Edit</a></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/delete_photo.php?pid=<?php echo $photo->id?>" onclick="return confirm ('Are you sure?');">Delete</a></td>
            <?php endforeach; ?>
        </table>        
    </div>
</div>

<?php include template_path("footer.php");?>
