<?php 

class OrderedItems {

  public function addOrderedItems ($conn, $item_id, $order_id, $price, $quantity){
    $sql = "INSERT INTO ordered_items (item_id, order_id, price, quantity)
    VALUES (:item_id, :order_id, :price, :quantity)";
    $stmt = $conn -> prepare($sql);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->bindParam(':order_id', $order_id);
    $stmt ->bindParam(':price', $price);
    $stmt ->bindParam(':quantity', $quantity);
    $stmt->execute();
  }
  public function getOrderedItems($conn, $order_id) {
    $sql = "SELECT * FROM ordered_items WHERE order_id=:order_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':order_id', $order_id);
    $stmt->execute(); 
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

}



?>