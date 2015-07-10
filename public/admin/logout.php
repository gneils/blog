<?php
require_once ("../../private/initialize.php");

if($session->is_logged_in()) {
    $session->logout();
}
redirect_to("login.php");
?>
