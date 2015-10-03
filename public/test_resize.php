<?php
$source_image =imagecreatefromgif( "images/cir.gif");
if(!$source_image ) {
    die('Error when reading the source image.');
}





$src_img = imagecreatefromgif('images/cir.gif');
$source_imagex = imagesx($src_img);
$source_imagey = imagesy($src_img);
$dest_imagex = 300; //The width that the image must be
$ratio = $dest_imagex / $source_imagex; //Calculating the appropriate height of the final image
$dest_imagey = $ratio * $source_imagey;
if(!$src_img) {
    die('Error when reading the source image.');
}
$thumbnail = imagecreatetruecolor($dest_imagex, $dest_imagey);
if(!$thumbnail) {
    die('Error when creating the destination image.');
}
$result = imagecopyresampled($thumbnail, $src_img, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);
if(!$result) {
    die('Error when generating the thumbnail.');
}
$result = imagegif($thumbnail, 'images/destination.gif');
if(!$result) {
    die('Error when saving the thumbnail.');
}
$result = imagedestroy($thumbnail);
if(!$result) {
    die('Error when destroying the image.');
}



//$dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);
//$image = imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);
//if ($image) {
////        switch($_FILES['userfile']['type']) {
//        switch('image/gif') {
//        case 'image/jpeg':
//            imagejpeg($dest_image, $target_out, 120);
//            break;
//        case 'image/png':
//            imagepng($dest_image, $target_out, 9);
//            break;
//        case 'image/gif':
//            imagegif($dest_image, $target_out);
//            break;
//    }
//    imagedestroy($source_image);
//    imagedestroy($dest_image);
//}
//?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resize Image</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

    <p>Completed Resize</p>
    <?php echo "$source_imagex by $source_imagey";?>
    <br><img src="images/cir.gif"><br>
    <?php echo "$dest_imagex by $dest_imagey";?>
    <br>
    <img src="images/destination.gif">

</body>
</html>  