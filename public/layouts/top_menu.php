<?php
    $sql = "SELECT * FROM posts ";
    $sql .= "ORDER BY event_date DESC ";
    $sql .= "LIMIT 10 ";
    $post_menus = Post::find_by_sql($sql);
    $sql = "SELECT * FROM photographs ";
    $sql .= "ORDER BY upload_time DESC ";
    $sql .= "LIMIT 10 ";
    $photo_menus = Photograph::find_by_sql($sql);
?>
<div class="row">
    <nav id="navbar-example" class="navbar navbar-default navbar-static">
      <div class="container-fluid">
        <div class="navbar-header">
          <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-example-js-navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo WEB_ROOT?>">Blog</a>
        </div>
        <div class="collapse navbar-collapse bs-example-js-navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a id="drop1" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Posts
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="drop1">
                <li><a href="<?php echo WEB_ROOT?>/admin/new_post.php">New Post</a></li>
                <li><a href="<?php echo WEB_ROOT?>/admin/list_posts.php">List Posts</a></li>
                <li><a href="<?php echo WEB_ROOT?>/admin/search.php">Search Posts</a></li>
                <li role="separator" class="divider"></li>
                <?php foreach($post_menus as $post_menu): ?>
                   <li><a href="<?php echo WEB_ROOT?>/admin/edit_post.php?pid=<?php echo $post_menu->id?>" title="<?php echo date_to_text($post_menu->event_date);?>">
                       <?php if(strlen (h($post_menu->title)) > 5) {
                       echo h(substr($post_menu->title,0,25));
                       } else  {
                        echo h(substr($post_menu->description,0,25)); 
                       }?>
                       </a>
                   </li>
                <?php endforeach; ?>
              </ul>
            </li>
            <li class="dropdown">
              <a id="drop2" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Photos
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="drop2">
                <li><a href="<?php echo WEB_ROOT?>/admin/photo_upload.php">New Photo</a></li>
                <li><a href="<?php echo WEB_ROOT?>/admin/list_photos.php">List Photos</a></li>
                <li role="separator" class="divider"></li>
                <?php foreach($photo_menus as $photo_menu): ?>
                   <li><a href="<?php echo WEB_ROOT?>/admin/edit_photo.php?pid=<?php echo $photo_menu->id?>" >
                       <?php if(strlen ($photo_menu->caption) > 5) {
                       echo h(substr($photo_menu->caption,0,25));
                       } else  {
                        echo h($photo_menu->filename); 
                       }?>
                       </a>
                   </li>
                <?php endforeach; ?>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li id="fat-menu" class="dropdown">
              <a id="drop3" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Admin
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="drop3">
                <?php 
                    if ($session->is_logged_in()) { 
                        echo "<li><a href=\"".WEB_ROOT."/admin/dashboard.php\">Dashboard</a></li>";
                        echo "<li><a href=\"".WEB_ROOT."/admin/manage_users.php\">Manage Users</a></li>";
                        echo "<li><a href=\"".WEB_ROOT."/admin/create_user.php\">New  User</a></li>";
                        echo "<li role=\"separator\" class=\"divider\"></li>";
                        echo "<li><a href=\"".WEB_ROOT."/admin/logfile.php\">Log File</a></li>";
                        echo "<li><a href=\"".WEB_ROOT."/to-do.php\">My To Do List</a></li>";
                        echo "<li role=\"separator\" class=\"divider\"></li>";
                        echo "<li><a href=\"".WEB_ROOT."/admin/logout.php\">Log Out</a></li>";
                    } else {
                        echo "<li><a href=\"".WEB_ROOT."/admin/login.php\">Log In</a></li>";
                    }
                ?>
              </ul>
            </li>
          </ul>
        </div><!-- /.nav-collapse -->
      </div><!-- /.container-fluid -->
    </nav> <!-- /navbar-example -->
</div>
