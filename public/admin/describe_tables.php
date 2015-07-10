<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php
$table = "photographs";
$query = "DESCRIBE ". $table;
$schema = $database->query($query);
$schema_rows = $database->num_rows($schema);
echo "<h2>$table</h2>";
echo "<table><tr><th>row</th><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>".PHP_EOL;
for ($j = 0; $j < $schema_rows; $j++) {
    $schema->data_seek($j);
    $row = $database->fetch_array($schema);
    echo "<tr><td>$j</td>".PHP_EOL;
    for ($k = 0; $k <4 ; ++$k) echo "<td>$row[$k]</td>".PHP_EOL ;
    echo "</tr>".PHP_EOL;
}
echo "</table>";

$query = "SELECT * FROM ". $table;
$results = $database->query($query);
$rows = $database->num_rows($results);
echo "<h2>$table DATA</h2>";
echo "<table><tr>";

for ($j = 0; $j < $schema_rows; $j++) {
    $schema->data_seek($j);
    $row = $database->fetch_assoc($schema);
    echo "<td>{$row['Field']}</td>";
}
echo "</tr>".PHP_EOL;
for ($j = 0; $j < $rows; $j++) {
    $results->data_seek($j);
    $row = $database->fetch_array($results);
    echo "<tr>".PHP_EOL;
    for ($k = 0; $k <4 ; ++$k) echo "<td>$row[$k]</td>".PHP_EOL ;
    echo "</tr>".PHP_EOL;
}
echo "</table>";

?>
