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
            <li>Change Person from open text to dropdown choice</li>
            <li>Make sure Post Date can go into database</li>
            <li>Update forms to include "visibility"</li>
            <li>Find good image manipulation library</li>
            <li>Email when new comment is posted</li>
            <li>How to approve new comment? Variable named "status"?</li>
            <li>How to easy embedding photos into posts</li>
            <li>Create Table by Table Check Digit</li>
        </ul>
    </div>
</div>
<br><br><br>
<?php include template_path("footer.php");?>