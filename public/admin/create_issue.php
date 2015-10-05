<?php require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); }
?>

<?php 
if (isset($_POST["submit"])) {
    // Process the form
    $description = $database->escape_value(s(filter_input(INPUT_POST, "description")));
    $curr_status = $database->escape_value(s(filter_input(INPUT_POST, "status")));
    $resolution = $database->escape_value(s(filter_input(INPUT_POST, "resolution")));
    // validations
    $required_fields = array("description");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("description" => 900,);
    validate_max_lengths($fields_with_max_lengths);
   
    $fields_with_min_lengths = array("description" => 5,); 
    validate_min_lengths($fields_with_min_lengths);

    if(!empty($errors)){
        $_SESSION["errors"] = $errors;
        redirect_to(WEB_ROOT."/admin/new_issue.php");
    }
    
    $query  = "INSERT INTO issues (";
    $query .= " description,";
    $query .= " curr_status,";
    $query .= " resolution";
    $query .= ") VALUES (";
    $query .= " '{$description}', ";
    $query .= " '{$curr_status}', ";
    $query .= " '{$resolution}'";
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