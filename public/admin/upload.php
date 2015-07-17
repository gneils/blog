<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) { redirect_to("login.php"); } ?>
<?php
// In an application, this could be moved to a config file
$upload_errors = array(
    // http://www.php.net/manual/en/features.file-upload.errors.php
    UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
    UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
    UPLOAD_ERR_NO_FILE => 'No file.',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder.',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
    UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.'
);
?>
<?php include template_path("header.php");?>
<?php include template_path("title.php");?>

<?php
if(isset($_POST['submit'])) {
    // proces the form data
    $tmp_file = $_FILES['file_upload']['tmp_name'];
    echo $tmp_file ."<hr >";
    $test = new Photograph;
    echo $test->attach_file($_FILES);
    $error = $_FILES['file_upload']['error'];
    $message = $upload_errors[$error];
}
?>

<div id="main">
    <h2>File Upload</h2>
    <?php if(!empty($message)) { echo "<p>{$message}</p>"; } ?>
    <form action ="upload.php" enctype="multipart/form-data" method="POST">
        <?php echo csrf_token_tag()?>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
        <input type="file" name="file_upload"/>
        <input type="submit" name="submit" value="upload" />
        
    </form>
</div>


<?php include template_path("footer.php");?>
