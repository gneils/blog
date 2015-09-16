<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">
<title>Test Page</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<style type="text/css">
</style>
</head>
<body>

<?php 
$startdate = "2015-09-12 07:00:00";
$enddate = "2015-09-14 16:00:00";
$datetime1 = new DateTime($startdate);
$datetime2 = new DateTime($enddate);
$interval = $datetime1->diff($datetime2);
$ptohours = $interval->format('%d %H');
echo $ptohours;
?>
</div>

</body>
</html>  