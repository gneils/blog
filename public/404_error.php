<?php 
require_once("../private/initialize.php");
include template_path("header.php");
include template_path("title.php");
include template_path("top_menu.php");
include template_path("session_message.php");
?>
<div class="row">
    <div class="col-md-12">
        <h2>Opps</h2> 
    </div>
</div>
<?php if(!isset($session->message)): ?>
	<div class="row">
	    <div class="col-md-12">
		<p>Sorry we can not find the page you were looking for</p>
	    </div>
	</div>
<?php endif; ?>
<?php include template_path("footer.php");?>
