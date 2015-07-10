<?php
require_once ("../private/initialize.php");

include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");

$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr />";

$users = User::find_all();
foreach($users as $user) {
    echo "User: " . $user->username . "<br / >";  
    echo "Name: " . $user->full_name() . "<br / >";  
}
//while ($user = $database->fetch_array($user_set)) {
//    echo "Name: " . $user['first_name'] . " " . $user['last_name'];
//    echo "<br / ><br / >";
//}
?>

<?php include template_path("footer.php");?>
