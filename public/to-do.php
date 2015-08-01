<?php 
    require_once ("../private/initialize.php");
    include template_path("header.php");
    include template_path("title.php");
    include template_path("top_menu.php");
?>

<div class="row">
    <div class="col-md-offset-3 col-md-6 ">
        <h3>My Simple to do list</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-offset-3 col-md-6 ">
        <ul>
            <li>Remove escape slashes from existing mysql database.</li>
            <li>Make to do list a table in the database.</li>
            <li>Possibly change name of variable named "public" to "visible".</li>
            <li>Add database schema to GITHUB.</li>
            <li>Auto-log out server side and client side. Remember multiple tabs may be open.</li>
            <li>Wire Frame entire project</li>
            <li>Download existing database and create code to move table data</li>
            <li>Update forms to include "visibility"</li>
            <li>Find good image manipulation library</li>
            <li>Email when new comment is posted</li>
            <li>How to approve new comment? Variable named "approved"?</li>
            <li>How to easy embedding photos into posts</li>
            <li>Create Table by Table Check Digit</li>
            <li>Admin Page to approve comments</li>
            <li>Only show approved comments</li>
            <li>Move Mailer from photo comment to its own class.</li>
            <li>Activate Visible in Posts.</li>
            <li>Activate Private in Posts.</li>
            <li>Scan code for possible hacks and attacks.</li>
        </ul>
    </div>
</div>
<br><br><br>
<?php include template_path("footer.php");?>