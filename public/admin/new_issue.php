<?php require_once("../../private/initialize.php") ?>
<?php if (!$session->is_logged_in()) {redirect_to(WEB_ROOT."/admin/login.php"); } ?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>
<div class="row">
    <div class="col-md-12">
        <h2>New Issue</h2>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-2 col-md-6">
        <?php echo $session->message(); ?>
        <?php echo $session->errors(); ?>
        <form action="create_issue.php" method="post" class="form-horizontal">
            <?php echo csrf_token_tag(); ?>
            <input type="hidden" name="submitted_by" value="<?php echo h($session->user_id);?>">
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description"  class="form-control" rows="5"></textarea>
            </div>
            <div class="form-group">
                <label for="priority">Priority</label>
                <select name="priority" id="status" class="form-control"> 
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control"> 
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="resolution">Resolution</label>
                <textarea name="resolution" id="resolution"  class="form-control" rows="5"></textarea>
            </div>
            <input type="submit" name="submit" value="Create Issue" class="btn btn-primary"/>
            <a href="<?php echo WEB_ROOT?>/admin/list_issues.php" class="btn btn-default">Cancel</a>
        </form>
    </div>
</div>
<?php include template_path("footer.php");?>