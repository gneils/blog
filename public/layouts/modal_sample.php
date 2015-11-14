<?php 
    $sql = "SELECT * FROM photographs ORDER BY RAND() LIMIT 6";
    $photo_grid = Photograph::find_by_sql($sql);
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
      <div class="modal-body">
          <img id="modalimage" src="" alt="Modal Photo" width="100%">
      </div>
  </div>
</div>

<div id="photo-grid" class="modalphotos photogrid clearfix">
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