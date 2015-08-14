<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php $persons = Post::get_all_persons();?>
<?php
if(request_is_post()) {
    if(!csrf_token_is_valid()) {
        $session->message("CSRF TOKEN MISSING OR MISMATCHED");
        redirect_to(WEB_ROOT."/admin/search.php");
    }    
//  Security Checks and Set Values
    $safe_description = $database->escape_value(s(trim(filter_input(INPUT_POST, "description"))));
    $fields_with_max_lengths = array("description" => 30);
    validate_max_lengths($fields_with_max_lengths);


    $required_fields = array("description");
    validate_presences($required_fields);

    $fields_with_min_lengths = array("description" => 2);
    validate_min_lengths($fields_with_min_lengths);

    if(!empty($errors)){
        $_SESSION["errors"] = $errors;
        redirect_to(WEB_ROOT."/admin/search.php");
    }
// Pagination
    // 1. the current page number ($current_page)
    $page = !empty($_GET['page'] ) ? (int)$_GET['page'] : 1;

    // 2. records per page ($per_page)
    $per_page = 15;
            
    // 3. total record count ($total_count)
    $sql_where = "WHERE description like \"%" . $safe_description . "%\" ";

    $total_count = Post::count_subset($sql_where);
    
    $pagination = new Pagination($page, $per_page, $total_count);
    
        // Instead of finding all records, just find the records for this page
    $sql = "SELECT * FROM posts ";
    $sql .= $sql_where;
    $sql .= "ORDER BY event_date DESC ";
    $sql .= "LIMIT {$per_page} ";
    $sql .= "OFFSET {$pagination->offset()} ";
    $posts = Post::find_by_sql($sql);
}
?>
<?php
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<?php 
// $message is just a variable, doesn't use the SESSION
 if (!empty($message)) {echo "<div class=\"message\">" . h($message) . "</div>";}
?>
<?php if(isset($errors)) {echo form_errors($errors);}?>
<p>To work on tomorrow.  Pagination works via links.  The search SQL only runs the first time.  It could work if the search criteria is either embedded into the url or if the search links are form submit buttons.
    It will have to be a session variable in order to work properly via links.</p>
<br>Also the posts form submits a value, which I changed to make it work for the search for.   Here is the code <pre>type="submit" name="submit" value="search"</pre>
<?php include template_path("post_form.php"); ?>
<br />



<?php
if(request_is_post()) {
    $link_page = "search";
    echo "{$sql_where}";
    include template_path("post_pagination.php");
}
?>
<?php include template_path("footer.php"); ?>