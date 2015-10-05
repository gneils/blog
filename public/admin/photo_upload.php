<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php // \php_error\reportErrors();?>

<?php 
    $max_file_size = 1048576 * 16; // expressed in bytes
    $message = "";
    if(isset($_POST['submit'])) {
        $photo = new Photograph();
        $photo->caption = s($_POST['caption']);
        $photo->description = s($_POST['description']);
        $photo->photo_date = s(filter_input(INPUT_POST, "photo_date"));
        $photo->photo_date = date('Y-m-d', strtotime($photo->photo_date)); 
        $photo->attach_file($_FILES['file_upload']);
        if($photo->save()) {
            $session->message("Photograph uploaded successfully.");
            redirect_to(WEB_ROOT.'/admin/list_photos.php');
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
                <label for="file_upload">Choose a photo</label>
                    <input type="file" name="file_upload" id="file_upload" />
                </span>
            </div>
            <div class="form-group">
                <label for="caption">Caption</label>
                <input type="text" name="caption" id="caption" maxlength="30" class="form-control" /> 
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="10"></textarea>
            </div>
            <div class ="row">
                <div class="form-group col-xs-4 ">
                    <label for="photo_date" class="control-label">Date photo taken</label>
                    <input type="date" name="photo_date" id="photo_date" class="form-control" value="" /> 
                </div>
            </div>

            <button type="submit" name="submit" value="upload" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>

<?php include template_path("footer.php");?>
