<!-- <?php
// session_start();
// $server_name = "localhost";
// $db_username = "root";
// $db_password = "";
// try{
//   $conn = new PDO("mysql:host=$server_name;dbname=sweetland_db", $db_username, $db_password);
// } catch (PDOException $e) {
//   echo "Connection to the database failed: " . $e->getMessage();
// } ?> -->


<?php
session_start();

//Get Heroku ClearDB connection information
$cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
$cleardb_server = $cleardb_url["host"];
$cleardb_username = $cleardb_url["user"];
$cleardb_password = $cleardb_url["pass"];
$cleardb_db = substr($cleardb_url["path"],1);
$active_group = 'default';
$query_builder = TRUE;
// Connect to DB
$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);


// $server_name = "localhost";
// $db_username = "root";
// $db_password = "";
// try{
//   $conn = new PDO("mysql:host=$server_name;dbname=sweetland_db", $db_username, $db_password);
// } catch (PDOException $e) {
//   echo "Connection to the database failed: " . $e->getMessage();
// } 
?>