<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php // \php_error\reportErrors();?>

<?php $max_file_size = 1048576; // expressed in bytes
    $message = "";
    if(isset($_POST['submit'])) {
        $photo = new Photograph();
        $photo->caption = $_POST['caption'];
        $photo->attach_file($_FILES['file_upload']);
        if($photo->save()) {
            $session->message("Photograph uploaded successfully.");
            redirect_to('list_photos.php');
        } else {
            $message = join("<br />", $photo->errors);
        } 
    } else {
       $message = "";
    }
?>
<?php include template_path("header.php"); ?>
<?php include template_path("title.php");?>
<?php include template_path("top_menu.php");?>


<div class="row">
    <div class="col-md-12">
        <h2>Photo Upload</h2>         
    </div>
</div>

<?php echo $message;?>
<div class="row">
    <div class="col-md-12">
        <form action ="" enctype="multipart/form-data" method="POST">
            <?php echo csrf_token_tag()?>
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size;?>" />
            <div class="form-group">
                <span class="btn btn-primary btn-file">
                <label for="file_upload">1. Choose a photo</label>
                    <input type="file" name="file_upload" id="file_upload" />
                </span>
            </div>
            <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" name="caption" id="caption" maxlength="30" class="form-control" /> 
            </div>
            <button type="submit" name="submit" value="upload" class="btn btn-primary">2. Submit</button>
        </form>
    </div>
</div>
<br />
<br />
<br />
<?php include template_path("footer.php");?>
