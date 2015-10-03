<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to("/admin/login.php"); } ?>
<?php 
// Create Checksum for whitelisted tables
$table_whitelist = array("comments", "issues", "photographs", "posts");
$table_counts= [];
foreach ($table_whitelist as $table_name) {
    $table_counts[$table_name] = $database->table_checksum($table_name);
}
?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Table by Table Checksums</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>Table Checksums</caption>
            <tr><th>Table Name</th>
                <th>Check sum</th>
            </tr>
            <?php foreach($table_counts as $table_name => $table_count): ?>
                <tr><td>
                    <a href="<?php echo WEB_ROOT . "/admin/describe_table.php?t=".$table_name;?>">
                    <?php echo $table_name;?></td><td><?php echo $table_count;?> 
                    </a>
                </td></tr>
            <?php endforeach; ?>
        </table>        
    </div>
</div>

<?php include template_path("footer.php");?>
