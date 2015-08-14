<?php require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); }
?>

<?php 
if (isset($_POST["submit"])) {
    // Process the form
    $description = s($database->escape_value(filter_input(INPUT_POST, "description")));
    // validations
    $required_fields = array("description");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("description" => 6000,);
    validate_max_lengths($fields_with_max_lengths);
   
    $fields_with_min_lengths = array("description" => 5,); 
    validate_min_lengths($fields_with_min_lengths);

    if(!empty($errors)){
        $_SESSION["errors"] = $errors;
        redirect_to(WEB_ROOT."/admin/new_issue.php");
    }
    
    $query  = "INSERT INTO issues (";
    $query .= " description";
    $query .= ") VALUES (";
    $query .= " '{$description}'";
    $query .= ")";

    $result = $database->query( $query );
    if ($result && $database->affected_rows() >=0) {
        // Success
        $_SESSION["message"] = "Issue created.";
        redirect_to(WEB_ROOT."/admin/list_issues.php");
    } else {
        // Failure
        $_SESSION["message"] = "Sorry failed to create the issue". $query;     
        redirect_to(WEB_ROOT."/admin/new_issue.php");
    }
} else {
    // this is probably a get request
    redirect_to(WEB_ROOT."/admin/new_issue.php");
}
?>