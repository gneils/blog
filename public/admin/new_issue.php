<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<div class="row">
    <div class="col-md-offset-2 col-md-6">
        <?php echo $session->message(); ?>
        <?php echo $session->errors(); ?>
        <h2>Create a new issue.</h2>
        <form action="create_issue.php" method="post" class="form-horizontal">
            <?php echo csrf_token_tag(); ?>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"  class="form-control" rows="5"></textarea>
            </div>
            <input type="submit" name="submit" value="Create Issue" class="btn btn-primary"/>
            <a href="<?php echo WEB_ROOT?>/admin/list_issues.php" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>

<?php include template_path("footer.php");?>