<?php
include("global/mysql.php");
include("classes/orders.class.php");
include("classes/user.class.php");
include("classes/menu_items.class.php");
include("classes/ordered_items.class.php");
include("classes/favorites.class.php");
if (isset($_SESSION['email'])) {
        
  $user = new User();
  $user_info = $user->getUserInfo($conn, $_SESSION['email']);
  $user_id = $user_info[0]['id'];
  $f_name = $user_info[0]['first_name']; }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "head.php" ?>
  <title>Menu</title>
</head>

<body>
  <?php include "components/nav_bar.php" ?>
  <div class="container best-sellers nav-bg">
    <div class="row">
      <h2 class="text display-6"> Our Products</h2>
      <?php
      // $user = new User();
      // $user_id = $user_info[0]['id'];

      $menu_obj = new MenuItems();
      $item = $menu_obj->getMenuItems($conn);

      if (isset($_SESSION['email'])) {

        $favorite_obj = new FavoriteItem();
        $all_favorites = $favorite_obj->check_if_favorite($conn, $user_id);

        foreach ($all_favorites as $listRow) {
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
                    <div class='col-2'></div>
                    <button data-id='" . $item_id . "' class='col-6  add-cart-item btn btn-primary text-white'>Add to Cart</button>";
          if ($listRow["is_favorite"] == 1) {
            echo "
                      <form method='POST' class='like_form col-3' action='./handle_unlike_menu.php'>
                      <input class='like-menu-item btn btn-primary text-white' type='submit' data-id='" . $item_id . "' name = '" . $item_id . "' value='Unlike'>
                      </form>";
          } else echo "
                      <form method='POST' class='like_form col-3' action='./handle_like_menu.php'>
                      <input class='like-menu-item btn btn-primary text-white' type='submit' data-id='" . $item_id . "' name = '" . $item_id . "' value='Like'>
                      </form>" ?><?php echo "
                      </div>
                    </div>
                    </div>
                    </div>";
                                }
        } else {
          $menu_obj = new MenuItems();
          $item = $menu_obj->getMenuItems($conn);
              foreach ($item as $listRow) {
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
                  <button data-id='" . $item_id . "' class='col-6 add-cart-item btn btn-primary text-white'>Add to Cart</button>
              </div>
            </div>
            </div>";
          }
          } ?>



                              
    </div>
  </div>
  <?php include "components/footer.php" ?>
</body>

</html>