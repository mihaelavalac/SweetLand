<!-- <?php
// session_start();
// $db_config = parse_ini_file(".env"); 
// if(getenv('APP_ENV') == 'production'){
//   $host = getenv('DB_HOST');
//   $db_username = getenv('DB_USERNAME');
//   $db_password = getenv('DB_PASSWORD');
//   $db_name= getenv('DB_NAME');
// } else {
//   $host = $db_config["DB_HOST"];
//   $db_username = $db_config["DB_USERNAME"];
//   $db_password = $db_config["DB_PASSWORD"];
//   $db_name= $db_config["DB_NAME"];
// }
// try{
//   $conn = new PDO ("mysql:host=$host;dbname=$db_name", $db_username, $db_password);
// } catch (PDOException $e) {
//   echo "Connection to the database failed: " . $e->getMessage();
// } ?> -->

<?php
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
?>
