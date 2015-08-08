<?php 

function strip_zeros_from_date( $marked_string=""){
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remoe an remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to( $location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;        
    }
}

function output_message($message=""){
    if (!empty($message)) {
        return ("<p class=\"message\">{$message}</p>");
    } else {
        return "";
    }      
}

function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = PRIVATE_PATH . DS . "includes" . DS . $class_name . ".php";
    if(file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

function template_path($template = "") {
    return (PUBLIC_PATH.DS."layouts".DS.$template);
}

function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
            $output = "<div class=\"row error\">";
            $output .="<div class=\"col-md-10 col-md-offset-1\"";
            $output .= "<p>Please fix the following errors:<p>";
            $output .= "<ul>";
            foreach ($errors as $key => $error) {
                $output .= "<li>";
                $output .= h($error);
                $output .= "</li>";
            }
            $output .= "</ul>";
            $output .= "</div>";
            $output .= "</div>";
	}
	return $output;
}

function fieldname_as_text($fieldname) {
    $fieldname = ucfirst(str_replace("_", " ", $fieldname));
    return $fieldname;
}


function generate_salt($length) {
    // Not 100% unique, not 100% random, but good enough for a salt
    // MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(), true));
    
    // Valid characters for a salt ar [1-ZA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);
    
    // But not '+' which is valid in base64 encoding 
    $modified_base64_string = str_replace('+', '.', $base64_string);
    
    // Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);
    
    return $salt;
}

function logged_in() {
    return isset($_SESSION["admin_id"]);
}

function confirm_logged_in() {
    if (!logged_in() ) {        
        redirect_to(WEB_ROOT."/admin/login.php");
    }
}
function password_encrypt($password) {
    $hash_format = "$2y$10$";
    $salt_length = 22;
    $salt = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hash = crypt($password, $format_and_salt);
    return $hash;
}


function password_check($password, $existing_hash) {
    // existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if($hash === $existing_hash) {
        return true;
    } else {
        return false;
    }
}

function datetime_to_text($datetime="") {
    $unixdatetime = strtotime($datetime);
    return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}

function date_to_text($date="") {
    $unixdatetime = strtotime($date);
    return strftime("%m/%d/%Y", $unixdatetime);
}

?>