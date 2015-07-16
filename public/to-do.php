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
        </ul>
    </div>
</div>
<br><br><br>
<?php include template_path("footer.php");?>