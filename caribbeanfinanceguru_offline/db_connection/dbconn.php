<?php
//Prod

$host =  "localhost";
$dbname = "";
$username = "";
$password = "";

$conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
$conn ->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
