<?php 
$server_name = "localhost";
$user_name = "root";
$password_db = "";
$dbname = "scarfity";

 $conn = new mysqli ($server_name, $user_name, $password_db , $dbname);

 if ($conn->connect_error) {
   die ("Connection failed: " . $conn->connect_error);
 }

 $conn->set_charset("utf8");
 
?>