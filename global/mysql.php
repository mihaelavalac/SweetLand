<?php
session_start();
$db_config = parse_ini_file(".env"); 


$host = $db_config["DB_HOST"];
$db_username = $db_config["DB_USERNAME"];
$db_password = $db_config["DB_PASSWORD"];
$db_name= $db_config["DB_NAME"];
try{
  $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_username, $db_password);
} catch (PDOException $e) {
  echo "Connection to the database failed: " . $e->getMessage();
} ?>

