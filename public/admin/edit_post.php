<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("WEB_ROOT.login.php"); } ?>
<?php
if(request_is_post()) {
    if(!csrf_token_is_valid()) {
        $session->message("CSRF TOKEN MISSING OR MISMATCHED");
        redirect_to(WEB_ROOT."/404_error.php");
    }    
    $post = Post::find_by_id($_POST["pid"]);
} else {
    $options = array( 'options' => array('default'=> 0) ); 

    if(!filter_input(INPUT_GET,"pid")) {
        $session->message("Whoops! Please go back to the form.  Required Fields Missing.");
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $is_number = has_number( filter_input(INPUT_GET,"pid"));
    if(!$is_number ) {
        $session->message("Wrong Post ID.");
        redirect_to(WEB_ROOT."/404_error.php");
    }
    $post = Post::find_by_id($_GET["pid"]);
}

if (!$post) {
    // ID was missing or invalid or 
    // ID couldn't be found in the database   
    $session->message("The post could not be found.");
    redirect_to(WEB_ROOT."/admin/list_posts.php"); 
}

if (isset($_POST["submit"])) {
    // Process the form
    // validations
    $fields_with_max_lengths = array("author" => 150,"tags" => 30, "person" => 30);
    validate_max_lengths($fields_with_max_lengths);


    if(empty($errors)){
        // perform update
        $safe_id = $database->escape_value(filter_input(INPUT_POST, "pid"));
        $safe_person = $database->escape_value(filter_input(INPUT_POST, "person" ) ) ;
        $safe_description = $database->escape_value(filter_input(INPUT_POST, "description" ) ) ;
        $safe_author = $database->escape_value(filter_input(INPUT_POST, "author" ) ) ;
        $safe_tags = $database->escape_value(filter_input(INPUT_POST, "tags" ) ) ;
        $query  = "UPDATE posts SET ";
        $query .= "person= '{$safe_person}', ";
        $query .= "description = '{$safe_description}', ";
        $query .= "author = '{$safe_author}', ";
        $query .= "tags = '{$safe_tags}' ";
        $query .= "WHERE id = {$safe_id} ";
        $query .= "LIMIT 1";

        //$result = mysqli_query($connection, $query);
        $result = $database->query( $query );
        
        if ($result && $database->affected_rows() >=0) {
            // Success
            $session->message("The post was updated.");
            redirect_to(WEB_ROOT."/admin/list_posts.php");
        } else {
            // Failure
            $message = "Sorry, the post was not updated:";
        }
    } else {
        // errors fall through to form below
    }
}
?>

<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<?php // $message is just a variable, doesn't use the SESSION
    if (!empty($message)) {echo "<div class=\"message\">" . h($message) . "</div>";}
?>
<?php if(isset($errors)) {echo form_errors($errors);}?>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <form action="<?php echo WEB_ROOT?>/admin/edit_post.php" method="post">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="pid" id="pid" maxlength="30" value="<?php echo h($post->id);?>" /> 
            <div class="form-group">
                <label for="Person">Person</label>
                <input type="text" name="person" id="person" maxlength="30" class="form-control" value="<?php echo h($post->person);?>"/> 
            </div>
            <div class="form-group">
                <label for="event_date">Date</label>
                <input type="date" name="event_date" id="event_date" class="form-control" value="<?php echo h($post->event_date);?>"/> 
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control"><?php echo h($post->description);?></textarea>
            </div>
            <div class="form-group">
                <label for="author">Author</label>
                <input type="text" name="author" id="author" maxlength="30" class="form-control" value="<?php echo h($post->author);?>"/> 
            </div>
            <div class="form-group">
                <label for="tags">Tags</label>
                <input type="text" name="tags" id="tags" maxlength="300" class="form-control" value="<?php echo h($post->tags);?>"/> 
            </div>
            <button type="submit" name="submit" value="edit-post" class="btn btn-primary">Save</button>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/list_posts.php">Cancel</a>
            &nbsp;
            <a class="btn btn-default" href="<?php echo WEB_ROOT?>/admin/delete_posts.php?pid=<?php echo u($post->id)?>" onclick="return confirm ('Are you sure?');">Delete photo</a>
        </form>
        <br />
    </div>
</div>
<br />
<br />

<?php include template_path("footer.php"); ?>