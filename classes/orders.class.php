<?php 
//include ("./order_history.php");

class Orders {

  public function add_order ($conn, $user_id) {
    $insert = "INSERT INTO orders (user_id) VALUES (:user_id)";
    $stmt = $conn -> prepare($insert);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute(); 
    $last_id = $conn->lastInsertId();
    return $last_id;

  }

  public function getOrders($conn, $user_id) {
    $sql = "SELECT * FROM orders WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute(); 
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }
}


?>

