<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<div class="row">
    <div class="col-md-12">
        <h2>Welcome to the Sandbox.  Test & develop code here.</h2>
    </div>
</div>
<?php if(isset($message)) { ?>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
        <h3>Place you code below:</h3> 
        <pre>
<?php 
    $string = " <div>\"hello\"   world 1 2 3 555</div><script>alert('hacked');</script> ";
    echo "original string: {$string}<hr>";
    echo "Filters: <br>";
    
    $safe_string = filter_var($string);
    echo "1. No Filter:".$safe_string."x<br>";
    
    $safe_string = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
    echo "2. Number:".$safe_string."x<br>";
    
    $safe_string = filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS);
    echo "3. Spec Chars:".$safe_string."x<br>";

    $safe_string = filter_var($string, FILTER_SANITIZE_STRING);
    echo "4. String:".$safe_string."x<br>";
    
    $safe_string = trim($string);
    echo "5. trimmed:".$safe_string."x<br>";
    
    $safe_string = s($string);
    echo "6. strip_tags:".$safe_string."x<br>";
    
    $safe_string = $database->escape_value($string);
    echo "7. DB Escape:".$safe_string."x<br>";

?>
</pre>
    </div>
</div>
<?php include template_path("footer.php");?>
