<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
$current_user = User::find_by_id($_SESSION['user_id']);
$persons = Post::get_all_persons();
?>
<div class="row">
    <div class="col-md-offset-2 col-md-6">
        <?php echo $session->message(); ?>
        <?php echo $session->errors(); ?>
        <h2>Create a new post.</h2>
        <form action="create_post.php" method="post" class="form-horizontal">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="author" id="author" maxlength="30" value="<?php echo $current_user->username;?>" /> 
            <div class="form-group">
                <label for="person">Person</label>
                <select name="person" id="person" class="form-control"> 
                    <?php 
                        foreach ($persons as $person) {
                            echo "<option value=\"".$person."\">".$person."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"  class="form-control" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" name="slug" id="slug" maxlength="40" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="event_date">Date</label>
                <input type="date" name="event_date" id="event_date" maxlength="30" class="form-control" value="" /> 
            </div>
            <div class="form-group">
                <label for="tags">tags</label>
                <input type="text" name="tags" id="tags" maxlength="100" class="form-control" value="" /> 
            </div>
            <input type="submit" name="submit" value="Create Post" class="btn btn-primary"/>
            <p>Placeholder for rating</p>
            <a href="<?php echo WEB_ROOT?>/admin/manage_posts.php" class="btn btn-default">Cancel</a>
        </form>
        <br />
        <br />
        <br />
        <br />
        <br />
    </div>
</div>

<?php include template_path("footer.php");?>