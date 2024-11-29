<?php 
$db_server = "localhost";
$db_user = "wosyrook_root";
$db_pass = "GreenEFX@#24";
$db_name = "wosyrook_greenefx_database";


   // Establish connection
   $con = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
   if (!$con) {
       die("Connection failed: " . mysqli_connect_error());
   }
?>