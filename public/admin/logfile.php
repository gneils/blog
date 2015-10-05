<?php require_once ("../../private/initialize.php"); ?>
<?php if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); } ?>

<?php 
    if(isset($_GET['clear'])) {
        $reset = trim($_GET['clear']);
        if($reset == "true"){
            if( file_exists($log_file) ) {
                if( is_readable($log_file)) {
                    clear_log();
                }
            }
        }
    }
?>

<?php include template_path("header.php");?>
<?php include template_path("title.php");?>
<?php include template_path("top_menu.php");?>


<div class="row">
    <div class="col-md-12">
        <h2>Log File</h2>
    <p><a href="<?php echo WEB_ROOT."/admin/logfile.php?clear=true"?>">Clear log file</a></p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    <?php echo show_log(); ?>
    <p><small>Blank Lines Removed<small</p>
    </div>
</div>

<?php include template_path("footer.php");?>
