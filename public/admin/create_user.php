<?php require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); }?>

<?php
if (isset($_POST["submit"])) {
    // Process the form
    $username = $database->escape_value(filter_input(INPUT_POST, "username"));
    $first_name = $database->escape_value(filter_input(INPUT_POST, "first_name"));
    $last_name = $database->escape_value(filter_input(INPUT_POST, "last_name"));

    $password = $_POST["password"];
    $email = $database->escape_value(filter_input(INPUT_POST, "email",FILTER_SANITIZE_EMAIL));
    $hashed_password = password_encrypt($password);
    $super_user = $database->escape_value(filter_input(INPUT_POST, "super_user",FILTER_SANITIZE_NUMBER_INT));
    
    // validations
    $required_fields = array("username", "first_name","last_name","password", "email");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("username" => 30,
                                    "password" => 60, 
                                    "first_name" => 60, 
                                    "last_name" => 60, 
                                    "email" => 50,
                                    "super_user" =>1);
    validate_max_lengths($fields_with_max_lengths);

    $email_fields = array("email");
    validate_emails($email_fields);
    
    $fields_with_min_lengths = array("username" => 8,
                                     "password" => 8,
                                     "first_name" => 2,
                                     "last_name" => 2,
    ); 
    validate_min_lengths($fields_with_min_lengths);

    if(!empty($errors)){
        $_SESSION["errors"] = $errors;
        redirect_to(WEB_ROOT."/admin/new_user.php");
    }
    if (!has_inclusion_in($super_user, [0,1])) {
        $super_user = 0;
    }
    
    $query  = "INSERT INTO users (";
    $query .= " username, password, first_name, last_name, email,super_user";
    $query .= ") VALUES (";
    $query .= "  '{$username}', '{$hashed_password }'";
    $query .= ", '{$first_name}', '{$last_name }'";
    $query .= ", '{$email}', super_user";
    $query .= ")";

    $result = $database->query( $query );
    if ($result && $database->affected_rows() >=0) {
        // Success
        $_SESSION["message"] = "User created.";
        redirect_to(WEB_ROOT."/admin/manage_users.php");
    } else {
        // Failure
        $_SESSION["message"] = "Sorry failed to create ". h(s($username))."<br>". $query;     
        redirect_to(WEB_ROOT."/admin/new_user.php");
    }
} else {
    // this is probably a get request
    redirect_to(WEB_ROOT."/admin/new_user.php");
}
?>