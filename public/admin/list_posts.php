<?php require_once ("../../private/initialize.php");?>
<?php if (!$session->is_logged_in()) {redirect_to("login.php"); } ?>
<?php $post_objects = Post::find_all();?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-12">
        <h2>Posts</h2> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <h3><?php echo output_message($message); ?></h3> 
    </div>
</div>
<div class="row">
    <div class="col-md-12">
<a href="<?php echo WEB_ROOT?>/admin/create_post.php" class="btn btn-primary">Create a new post</a>
    </div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>Posts</caption>
            <tr><th>Person</th><th>Date</th><th>Description</th><th>Author</th><th>Tags</th><th>Rating</th><th colspan="2">Action</th></tr>
            <?php foreach($post_objects as $post): ?>
                <tr>
                <td><?php echo $post->person; ?></td>
                <td><?php echo date_to_text($post->event_date); ?></td>
                <td><?php echo $post->description; ?></td>
                <td><?php echo $post->author?></td>
                <td><?php echo $post->tags?></td>
                <td><?php echo $post->rating?></td>               
                <td><a href="<?php echo WEB_ROOT?>/admin/edit_post.php?pid=<?php echo $post->id?>">Edit</a></td>
                <td><a href="<?php echo WEB_ROOT?>/admin/delete_post.php?pid=<?php echo $post->id?>" onclick="return confirm ('Are you sure?');">Delete</a></td>
            <?php endforeach; ?>
        </table>        
    </div>
</div>
<br><br><br>
<?php include template_path("footer.php");?>
