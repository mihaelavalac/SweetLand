<?php
      session_start();
      $db_config = parse_ini_file(".env"); 
      $isProduction = true; // keep false in local
      $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
      if($isProduction){
        $host = $cleardb_url["host"];
        $db_username = $cleardb_url["user"];
        $db_password = $cleardb_url["pass"];
        $db_name= substr($cleardb_url["path"],1);
      } else {
        $host = $db_config["DB_HOST"];
        $db_username = $db_config["DB_USERNAME"];
        $db_password = $db_config["DB_PASSWORD"];
        $db_name= $db_config["DB_NAME"];
      }
      try{
        $conn = new PDO ("mysql:host=$host;dbname=$db_name", $db_username, $db_password);
      } catch (PDOException $e) {
        echo "Connection to the database failed: " . $e->getMessage();
      }
