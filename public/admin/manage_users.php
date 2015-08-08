<?php
require_once ("../../private/initialize.php");
if (!$session->is_logged_in()) { redirect_to(WEB_ROOT."/admin/login.php"); }
?>
<?php $users = User::find_all();?>
<?php 
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
include template_path("session_message.php");
?>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped">
            <caption>Manage Users</caption>
            <tr><th style="width:200px;text-align:left;">Username</th>
                <th style="width:300px;text-align:left;">Name</th>
                <th colspan="2" style="text-align:left;width:200px">Actions</th>
            </tr>
            <?php foreach($users as $user)  { ?>
                <tr>
                    <td><?php echo h($user->username);?></td>
                    <td><?php echo h($user->full_name());?></td>
                    <td><a href="<?php echo WEB_ROOT?>/admin/edit_user.php?user=<?php echo u($user->id) ;?>">Edit</a></td>
                </tr>
            <?php } ?>
        </table>
        <br />
        <a href="new_user.php" class="btn btn-default">+ Add New User</a>    
        <a href="dashboard.php" class="btn btn-default">Back to Dashboard</a>      
    </div>
</div>
<br>
<br>


<?php include template_path("footer.php");?>