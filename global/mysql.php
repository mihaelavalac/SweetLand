<?php
//Get Heroku ClearDB connection information
if (getenv('APP_ENV') == 'production') {
  $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
  $cleardb_server = $cleardb_url["host"];
  $cleardb_username = $cleardb_url["user"];
  $cleardb_password = $cleardb_url["pass"];
  $cleardb_db = substr($cleardb_url["path"], 1);
  $active_group = 'default';
  $query_builder = TRUE;
  // Connect to DB
  //$conn = new PDO ($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);
  $conn = new PDO("mysql:host=$cleardb_server;dbname=$$cleardb_db", $cleardb_username, $cleardb_password);
} else {  {

    $db_config = parse_ini_file(".env");
    $host = $db_config["DB_HOST"];
    $db_username = $db_config["DB_USERNAME"];
    $db_password = $db_config["DB_PASSWORD"];
    $db_name = $db_config["DB_NAME"];
  }
  try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $db_username, $db_password);
    //$conn = mysqli_connect($host, $db_username, $db_password, $db_db);
  } catch (PDOException $e) {
    echo "Connection to the database failed: " . $e->getMessage();
  }
}
?>