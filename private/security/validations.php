<?php 
$errors = array();

function allowed_get_params($allowed_params=[]) {
    $allowed_array = [];
    foreach($allowed_params as $param) {
        if(isset($_GET[$param])) {
            $allowed_array[$param] = $_GET[$param];
        } else {
            $allowed_array[$param] = NULL;
        }
    }
    return $allowed_array;
}

function allowed_post_params($allowed_params=[]) {
    $allowed_array = [];
    foreach($allowed_params as $param) {
        if(isset($_POST[$param])) {
            $allowed_array[$param] = $_POST[$param];
        } else {
            $allowed_array[$param] = NULL;
        }
    }
    return $allowed_array;
}

// * validate value has presence
// use trim() so empty spaces don't count
// use === to avoid false positives
// empty() would consider "0" to be empty
function has_presence($value){
    $trimmed_value = trim($value);
    return isset($trimmed_value) && $trimmed_value !== "";
}

function validate_presences($required_fields) {
    global $errors;
    foreach($required_fields as $field) {
        $value = trim($_POST[$field]);
        if(!has_presence($value)) {
            $errors[$field] = fieldname_as_text($field). " can't be blank.";
        }
    }
}

// * valide value has string length
// leading and trailing spaces will count
// options: exact, max, min
// has_length($first_name, ['exact' => 20])
// has_length($first_name, ['min' => 5, 'max' => 100])
function has_length($value, $options=[]) {
    if(isset($options['max']) && (strlen($value) > (int)$options['max'])) {
        return false;
    }
    if(isset($options['min']) && (strlen($value) < (int)$options['min'])) {
        return false;
    }
    if(isset($options['exact']) && (strlen($value) != (int)$options['exact'])) {
        return false;
    }
    return true;
}

function validate_max_lengths($fields_with_max_lengths=[]) {
    global $errors;
    // Expects an assoc. array
    foreach($fields_with_max_lengths as $field => $max) {
        $value = trim($_POST[$field]);      
        $options = array("max"=>$max);
        if (!has_length($value, $options)) {
            $errors[$field] = fieldname_as_text($field) . " is too long";
        }
    }
}

function validate_min_lengths($fields_with_min_lengths=[]) {
    global $errors;
    // Expects an assoc. array
    foreach($fields_with_min_lengths as $field => $min) {
        $value = trim($_POST[$field]);
        $options = array("min"=>$min);
        if (!has_length($value, $options)) {
            $errors[$field] = fieldname_as_text($field) . " is too short";
        }
    }
}

// * validate value has a format matchin a regular expression
// Be sure to use anchor expressions to match start and end of string.
// (Use \A and \Z not ^ and $ which allow line returns.)
// Examples:
// has_format_matching('1234', '/\d{4}/') is true
// has_format_matching('12345', '/\d{4}/') is also true
// has_format_matching('12345', '/\A\d{4}\Z/') is false
function has_format_matching($value, $regex='//') {
    return preg_match($regex, $value);
}

// * validate value is a number
// submitted values are strings, so use is_numeric instead of is_int
// options: max, min
// has_number($items_to_order, ['min' => 1, 'max' => 5])
function has_number($value, $options=[]){
    if(!is_numeric($value)) {
        return false;
    }
    if(isset($options['max']) && ($value > (int)$options['max'])) {
        return false;
    }
    if(isset($options['max']) && ($value < (int)$options['min'])) {
        return false;
    }
    return true;
}

function validate_emails($email_fields) {
    global $errors;
    foreach($email_fields as $field) {
        $value = trim($_POST[$field]);
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$field] = fieldname_as_text($field). " is not an email.";
        }
    }
}

// * validate value is included in a set
function has_inclusion_in($value, $set=[]) {
    return in_array($value, $set);
}

// * validate value is excluded from a set 
function has_exclusion_in($value, $set=[]) {
    return !in_array($value, $set);
}

// * validate uniqueness
// A common validation, but not an easy one to write generically.
// Requires going to the database to check if value is already present.
// Implementation depends on your database set-up.
// Instead, her is a mock-up of the concept.
// Be sure to escape the user-provided value before sending it to the database
// Table and column will be provided by us and escaping them is optional.
// Also consider whether you want to trim whitespace, or make the query case-sensitive or not.
// 
// function has_uniqueness($value, $table, $column) {
//   $escaped_value = mysql_escape($value);
//    sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = '{escaped_value}';"
// if count > 0 then value is already present and not unique
// }


// ---------------------------------------------
// GET requests should not make changes
// Only POST requests should make changes

function request_is_get() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function request_is_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}
/* Usage: 
    if(request_is_post()) {
        ... process form, update database, etc.
    } else {
        ... do something safe, redirect, error page, etc
    }
*/


?>