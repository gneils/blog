<?php require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); }
?>

<?php 
if (isset($_POST["submit"])) {
    // Process the form
    $author = s($database->escape_value(filter_input(INPUT_POST, "author")));
    $person = s($database->escape_value(filter_input(INPUT_POST, "person")));
    $title = s($database->escape_value(filter_input(INPUT_POST, "title")));
    $description = s($database->escape_value(filter_input(INPUT_POST, "description")));
    
    $event_date = filter_input(INPUT_POST, "event_date");
    $sqlDate = date('Y-m-d', strtotime($event_date));    
    // validations
    $required_fields = array("author", "person", "event_date","description");
    validate_presences($required_fields);
    
    $fields_with_max_lengths = array("person" => 30,
                                     "description" => 6000,);
    validate_max_lengths($fields_with_max_lengths);
   
    $fields_with_min_lengths = array("person" => 2,
                                     "description" => 5,
    ); 
    validate_min_lengths($fields_with_min_lengths);

    if(!empty($errors)){
        $_SESSION["errors"] = $errors;
        redirect_to(WEB_ROOT."/admin/new_post.php");
    }
    
    $query  = "INSERT INTO posts (";
    $query .= " author, person, title, event_date, description";
    $query .= ") VALUES (";
    $query .= " '{$author}',";
    $query .= " '{$person}',";
    $query .= " '{$title}',";
    $query .= " '{$sqlDate}', ";
    $query .= " '{$description}'";
    $query .= ")";

    $result = $database->query( $query );
    if ($result && $database->affected_rows() >=0) {
        // Success
        $_SESSION["message"] = "Post created.";
        redirect_to(WEB_ROOT."/admin/list_posts.php");
    } else {
        // Failure
        $_SESSION["message"] = "Sorry failed to create ". h(s($username))."<br>". $query;     
        redirect_to(WEB_ROOT."/admin/new_posts.php");
    }
} else {
    // this is probably a get request
    redirect_to(WEB_ROOT."/admin/new_post.php");
}
?>