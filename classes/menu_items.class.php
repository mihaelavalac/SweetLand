<?php
// include ('db_conn.class.php');

class MenuItems {

  public function getMenuItems ($conn) {
    $sql = "SELECT * FROM menu_items";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
  }
  

  public function getCartItems ($conn, $ids) {
    $sql = "SELECT * FROM menu_items WHERE FIND_IN_SET(`id`, $ids)";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
  }

  public function getItemPrice($conn, $item_id) {
    $sql = "SELECT price FROM menu_items WHERE id=:item_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();
    $price = $stmt->fetch();
    return $price;
  }

  public function getFavoriteOrOrderedItems($conn, $item_id) {
    $sql = "SELECT * FROM menu_items WHERE id=:item_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    return $stmt->fetchAll();
  }



}


