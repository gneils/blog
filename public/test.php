<html lang="en">
 <head>
  <title>Array Pointers</title>
 </head>
 <body>
  <?PHP 
   $age = [4,6,8,12,15,28];
   echo( gettype($age) ) ; // returns array. 
   while ($age = current($age))
   {
    echo $age . "<br>";
    echo( gettype($age) ) ;  // returns integer
    next($age);
   }  
   ?>
 </body> 
</html>