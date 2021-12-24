<?php
include("global/mysql.php");
include("classes/orders.class.php");
include("classes/user.class.php");
include("classes/menu_items.class.php");
include("classes/ordered_items.class.php");
include("classes/favorites.class.php");

//Get User ID
$user = new User();
$user_info = $user->getUserInfo($conn, $_SESSION['email']);
$user_id = $user_info[0]['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $favoriteId = array_keys($_POST)[0];
  $favorite_obj = new FavoriteItem();
  $favorite_item = $favorite_obj->remove_favorite_item($conn, $user_id, $favoriteId);
}
header('Location: ./favorites.php');

?>


