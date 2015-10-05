<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php 
// Create Checksum for whitelisted tables
$table_whitelist = array("comments", "issues", "photographs", "posts");
$table_counts= [];
foreach ($table_whitelist as $table_name) {
    $table_counts[$table_name] = $database->table_checksum($table_name);
}

if (isset($_GET["t"])) {
    // Process the form
    // validations       
    $result = has_inclusion_in(filter_input(INPUT_GET, "t" ), $table_whitelist);
    if (!$result) {
        $errors["Table Name"] = "Not a valid table.";
    }
    
    if(empty($errors)){
        // perform update
        $table_name = $database->escape_value(filter_input(INPUT_GET, "t"));
        $query  = "describe ". $table_name;
        //$result = mysqli_query($connection, $query);
        $result = $database->query( $query );
        $cnt_result = $database->query("SELECT COUNT(*) FROM ". $table_name);
        $row = $database->fetch_array($cnt_result);
        $cnt= array_shift($row);
    } else {
        // errors fall through to form below
    }
} // end if (isset($_POST["submit"])) 
?>



<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Table Description</h2> 
        <h3><?php echo $table_name ?> has <?php echo $cnt;?> row(s). </h3> 
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
            <tr>
                <th>Field</th>
                <th>Type</th>
                <th>Null</th>
                <th>Key</th>
                <th>Default</th>
                <th>Extra</th>    
            </tr>
            <?php 
                foreach ($result as $results){
                    echo "<tr>";
                    foreach ($results as $field=>$value){
                        echo "<td>".  $value . "</td>";
                    }
                    echo "</tr>";
                }
            ?>
        </table>        
    </div>
</div>
<?php include template_path("footer.php");?>
