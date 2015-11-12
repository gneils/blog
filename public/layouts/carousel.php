<?php 
    $sql = "SELECT * FROM photographs ORDER BY RAND() LIMIT 5";
    $photo_slides = Photograph::find_by_sql($sql);
    $initialized = 0;
?>

<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="5000">
  <!-- Indicators -->
  <ol class="carousel-indicators" >
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="1" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="2" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="3" ></li>
    <li data-target="#carousel-example-generic" data-slide-to="4" ></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox" style="max-height: 350px;">
    <?php foreach($photo_slides as $slide): ?>
      <div class="item 
           <?php if($initialized == 0) {echo " active";}?> "> <?php $initialized++;?>
      <img src="<?php echo WEB_ROOT."/".h($slide->image_path()); ?>" alt="carousel slide" style="margin: 0 auto;">
      <div class="carousel-caption">
        <?php echo $slide->caption; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>