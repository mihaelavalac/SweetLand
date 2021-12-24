<?php
session_start();
$server_name = "localhost";
$db_username = "root";
$db_password = "";
try{
  $conn = new PDO("mysql:host=$server_name;dbname=sweetland_db", $db_username, $db_password);
} catch (PDOException $e) {
  echo "Connection to the database failed: " . $e->getMessage();
} ?>
