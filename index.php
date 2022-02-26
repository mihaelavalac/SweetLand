<?php
include 'global/mysql.php';
include './classes/favorites.class.php';
include './classes/menu_items.class.php';
include './classes/user.class.php';
include './classes/orders.class.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include "head.php";
  if (isset($_SESSION['email'])) {
    $user = new User();
    $user_info = $user->getUserInfo($conn, $_SESSION['email']);
    $f_name = $user_info[0]['first_name'];
    $user_id = $user_info[0]['id']; }
  ?>
  <meta name="description" content="Sweetland home page is the site of the most tasty cakes in USA.">
  <title>Sweetland Home Page</title>
  <meta>
</head>

<body>
  <?php include("components/nav_bar.php"); ?>
  <div id='banner' class='home-banner' style="font-size:xx-large">
    <!--   -->
    <img class = " image-fluid"id='banner-img' src='img/banner.jpeg' alt='Sweets' style='width:100%; min-height:150px !important'>
    

    <?php
    if (isset($_SESSION['email'])) {
      echo "<div class='home-message '><p>Welcome to Sweetland " . $f_name . "!</p></div>"
    ?>

    <?php
    } else {
      echo "<div class='home-message row text-center'><p>Welcome to Sweetland!</p> 
      <!--  <a href = 'login.php' class='col-5 btn btn-primary btn-sm text-white m-1' type='submit'><b>Log In</b></a>
      <a href = 'sign_up.php' class='col-5 btn btn-primary btn-sm text-white m-1' type='submit'><strong>Sign Up</strong></a> -->
      </div>";
    }
    ?>

  </div>

  <?php
  if (isset($_SESSION['email'])) {
    include('components/user_links.php');
  }
  ?>

  <br>

  <div class="container best-sellers nav-bg">
    <div class="row mb-5">
      <h2 class="display-6 "><strong>Just For YOU</strong> </h2>

      <?php
      $menu_obj = new MenuItems();
      $item = $menu_obj->getMenuItems($conn);

      $favorite_obj = new FavoriteItem();
      $all_favorites = $favorite_obj->check_if_favorite($conn, $user_id);
      if (isset($_SESSION['email'])) {
        foreach (array_slice($all_favorites, 0, 6) as $listRow) {
          $item_id = $listRow['id'];
          $name = $listRow['name'];
          $description = $listRow['description'];
          $price = $listRow['price'];
          $image = $listRow['image'];
          echo " <div class='col-sm-12 col-md-6 col-lg-4'> 
                  <div class='card m-2'>
                  <img class='card-img-top' src=" . $image . " alt='Card image cap'>
                  <div class='card-body text-darks'>
                  <p class=' h5 card-title'>" . $name . "</p>  
                  <p class='card-text'>" . $description . "</p>
                  <p class='card-text'><strong>$" . $price . "</strong></p>
                  <div class='row text-center'>
                  <div class='col-2'></div>
                  <button data-id='" . $item_id . "' class='col-6 add-cart-item btn btn-primary text-white'>Add to Cart</button>
                  "; if ($listRow["is_favorite"] == 1) { echo "
                  <form method='POST' class='like_form col-3' action='./handle_unlike.php'>
                  <input class='like-menu-item btn btn-primary text-white' type='submit' data-id='" . $item_id . "' name = '" . $item_id . "' value='Unlike'>
                  </form>"; } else echo "
                  <form method='POST' class='like_form col-3' action='./handle_like.php'>
                  <input class='like-menu-item btn btn-primary text-white' type='submit' data-id='" . $item_id . "' name = '" . $item_id . "' value='Like'>
                  </form>"?><?php echo "
                  </div>
                </div>
                </div>
                </div>";
        }
      } else {
        foreach (array_slice($item, 0, 3) as $listRow) {
          $item_id = $listRow['id'];
          $name = $listRow['name'];
          $description = $listRow['description'];
          $price = $listRow['price'];
          $image = $listRow['image'];

          echo " <div class='col-sm-12 col-md-6 col-lg-4'> 
              <div class='card m-2'>
              <img class='card-img-top' src=" . $image . " alt='Card image cap'>
              <div class='card-body text-darks'>
              <p class=' h5 card-title'>" . $name . "</p>
              <p class='card-text'>" . $description . "</p>
              <p class='card-text'><strong>$" . $price . "</strong></p>
                <button data-id='" . $item_id . "' class='add-cart-item btn btn-primary text-white'>Add to Cart</button>
            </div>
          </div>
          </div>";
        }
      }

      ?>
    </div>
  </div>
  <?php
  include("components/footer.php");
  ?>
</body>

</html>