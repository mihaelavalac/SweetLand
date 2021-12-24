<?php
// include ('db_conn.class.php');

class FavoriteItem{

  public function add_favorite_item($conn, $user_id, $item_id, $is_favorite) {
    $sql = "INSERT INTO favorites (user_id, item_id, is_favorite)
    VALUES (:user_id, :item_id, :is_favorite)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->bindParam(':is_favorite', $is_favorite);
    $stmt->execute();
  }

  public function display_favorite_item($conn, $user_id){
    $sql = "SELECT item_id FROM favorites WHERE user_id=:user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    // $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $matchingItems =  $stmt->fetchAll();
    return $matchingItems;
  }

  public function remove_favorite_item($conn, $user_id, $item_id)
  {
    $sql = "DELETE FROM `favorites` WHERE user_id=:user_id and item_id = :item_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':item_id', $item_id);
    $stmt->execute();
    header("Location: favorites.php");
  }


  public function check_if_favorite($conn, $user_id){
    $sql = "SELECT menu_items.id, menu_items.name, menu_items.description, menu_items.price, menu_items.image, favorites.is_favorite
    FROM favorites
    RIGHT JOIN menu_items
    on favorites.`item_id` = menu_items.id and favorites.`user_id` = :user_id";
    $stmt = $conn->prepare($sql);
    // $stmt->bindParam(':item_id', $item_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $matchingItems =  $stmt->fetchAll();
    return $matchingItems;
  }

}
