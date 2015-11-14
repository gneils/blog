<?php 
    $sql = "SELECT * FROM photographs ORDER BY RAND() LIMIT 6";
    $photo_grid = Photograph::find_by_sql($sql);
?>

<div id="photo-grid" class="component photogrid clearfix">
    <?php foreach($photo_grid as $slide): ?>
        <img src="<?php echo WEB_ROOT."/".h($slide->image_path()); ?>" 
        alt="<?php echo $slide->caption; ?>" 
        class ="drop-shadow"
        style="width:30%;"
         data-trigger="hover"
         data-toggle="tooltip" 
         data-placement="top"
         data-animation="true"
         data-title="<?php echo $slide->caption; ?>"
        >
    <?php endforeach; ?>
</div>