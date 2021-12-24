<?php
include './global/mysql.php';
include './classes/user.class.php';
include './classes/favorites.class.php';
include './classes/menu_items.class.php';
?>
<?php
if (isset($_SESSION['email'])) {
  $user = new User();
  $user_info = $user->getUserInfo($conn, $_SESSION['email']);
  $user_id = $user_info[0]['id'];
  $f_name = $user_info[0]['first_name']; 
}
$favoriteObj = new FavoriteItem();
$menu_obj = new MenuItems();
$favorite_item_id = $favoriteObj->display_favorite_item($conn, $user_id);

$all_favorites = $favoriteObj->check_if_favorite($conn, $user_id);
foreach ($all_favorites as $listRow) {
  if ($listRow["is_favorite"] == 1) {
    // echo $listRow["name"] . ' is a favorite item!</br>';
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include "head.php";
  ?>
</head>

<body>
  <?php include("components/nav_bar.php"); ?>
  <div class='container p-4'>

    <div class="row">

      <?php
      if (!$favorite_item_id) { ?>
        <div class="container  d-flex flex-column  justify-content-center align-items-center" style=" height:600px; margin-top:50px !important; margin-bottom:50px !important">
          <h2 class="align-self-center">You don't have any cakes added to your favorites</h2>
          <p class="align-self-center">Click the button bellow to add to your favorites</p>

          <a class="align-self-center btn-primary text-white bold p-3 rounded" href="./menu.php">Add Favorites</a>
          </p>
        </div>
      <?php
      } else {
      ?> <div class="row">
          <h1 class=''> Your Favorites</h1>
        </div> <?php
                foreach ($favorite_item_id as $listRow) {
                  $item_id = ($listRow['item_id']);
                  $favorite_item = $menu_obj->getFavoriteOrOrderedItems($conn, $item_id);
                  foreach ($favorite_item  as $listRow) {
                    $item_id = $listRow['id'];
                    $name = $listRow['name'];
                    $description = $listRow['description'];
                    $price = $listRow['price'];
                    $image = $listRow['image'];
                    echo " <div class='col-sm-12 col-md-6 col-lg-4'> 
                  <div class='card m-2'>
                  <img class='card-img-top' src=" . $image . " alt='Card image cap'>
                  <div class='card-body text-darks'>
                  <h5 class='card-title'>" . $name . "</h5>  
                
                  <p class='card-text'>" . $description . "</p>
                  <p class='card-text'><strong>$" . $price . "</strong></p>
                  <div class='row text-center'>
                    <button data-id='" . $item_id . "' class='col-6 add-cart-item btn btn-primary text-white'>Add to Cart</button>
                    <form method='POST' class='like_form col-6' action= './handle_favorites.php '>
                    <input class='like-menu-item btn btn-primary text-white' type='submit' data-id='" . $item_id . "' name = '" . $item_id . "' value='Unlike'>
                    </form>
                  </div>
                </div>
                </div>
                </div>";
                  }
                }
              } ?>
    </div>
  </div>
  <?php
  include("components/footer.php");
  ?>
</body>


</html>