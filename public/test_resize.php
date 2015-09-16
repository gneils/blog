<?php
$source_image = "images/a.jpg";
$source_imagex = imagesx($source_image);
$source_imagey = imagesy($source_image);
$dest_imagex = 300; //The width that the image must be
$ratio = $dest_imagex / $source_imagex; //Calculating the appropriate height of the final image
$dest_imagey = $ratio * $source_imagey;
$dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);
$image = imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);
if ($image) {
        switch($_FILES['userfile']['type']) {
        case 'image/jpeg':
            imagejpeg($dest_image, $target_out, 120);
            break;
        case 'image/png':
            imagepng($dest_image, $target_out, 9);
            break;
        case 'image/gif':
            imagegif($dest_image, $target_out);
            break;
    }
    imagedestroy($source_image);
    imagedestroy($dest_image);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>caro homepage</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

    <p>Completed Resize</p>

</body>
</html>  