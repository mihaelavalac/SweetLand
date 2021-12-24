<?php
include("global/mysql.php");
include("classes/menu_items.class.php");
include './classes/user.class.php';
if (isset($_SESSION['email'])) {
  $user = new User();
  $user_info = $user->getUserInfo($conn, $_SESSION['email']);
  $f_name = $user_info[0]['first_name'];
  $user_id = $user_info[0]['id']; }
if (isset($_GET['ids'])) {
  $ids = $_GET['ids'];
  $menu_items = new MenuItems();
  $cart_menu_items = $menu_items->getCartItems($conn, $ids);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "head.php"; ?>
  <title>Shopping Cart</title>
</head>

<body>
  <?php include "components/nav_bar.php" ?>
  <!-- This page is in progress as of 11/08/2021 -->
  <?php if (isset($_GET['ids'])) {
    echo '<div class="container" style=" min-height:600px; margin-top:50px !important; margin-bottom:50px !important">
    <div class="row">
      <aside class="col-lg-9">
        <div class="card">
          <div class="table-responsive">
            <table class="table table-borderless table-shopping-cart">
              <thead class="text-muted">
                <tr class="small text-uppercase">
                  <th scope="col">Product</th>
                  <th scope="col" width="120">Quantity</th>
                  <th scope="col" width="120">Price</th>
                  <th scope="col" class="text-right d-none d-md-block" width="200"></th>
                </tr>
              </thead>
              <tbody>';
    foreach ($cart_menu_items as $listRow) {
      $options = '';
      if ($listRow["quantity"]) {
        for ($i = 0; $i <= $listRow["quantity"]; $i += 1) {
          $options .= "<option>" . ($i + 1) . "</option>";
        }
        echo '
              <tr>
              <td>
                  <figure class="itemside align-items-center">
                      <div class="aside"><img src="./' . $listRow['image'] . '" class="img-sm"></div>
                      <figcaption class="info"> <p class="title text-dark" data-abc="true">' . $listRow['name'] . '</p>
                      </figcaption>
                  </figure>
              </td>
              <td> <select class="card-item-quantity form-control" data-id="' . $listRow['id'] . '" data-price="' . $listRow['price'] . '">
                      ' . $options . '
                  </select> </td>
              <td>
                  <div class="price-wrap"> <var class="price">$' . $listRow['price'] . '</var></div>
              </td>
              <td class="text-right d-md-block"><button href="" class="remove-cart-item btn btn-light" data-id="' . $listRow['id'] . '"> Remove</button> </td>
          </tr>
              ';
      }
    }
    echo '</tbody>
    </table>
    </div>
    </div>
    </aside>
    <aside class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <dl class="dlist-align">
            <dt>Total price:&nbsp;</dt>
            <dd class="text-right text-dark b ml-3"><strong class="total-price">$00.00</strong></dd>
          </dl>
          <hr> <button class="btn btn-out btn-primary btn-square btn-main" data-toggle="modal" data-target="#exampleModalCenter" data-abc="true"> Make Purchase </button>
          <a href="./menu.php" class="btn btn-out btn-success btn-square btn-main mt-2" data-abc="true">Continue Shopping</a>
        </div>
      </div>
    </aside>
    </div>
    </div>';

    if (isset($_SESSION['email'])) {
      $finalOrder = '';
      foreach ($cart_menu_items as $listRow) {
        $finalOrder .= '<div><p><strong>' . $listRow['name'] . '</strong> <span>$' . $listRow['price'] . '</span> X <span class="final-card-item-quantity" data-id ="' . $listRow['id'] . '">1</span></p></div>';
      }
      echo '<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Order Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             ' . $finalOrder . '
             <hr>
             <div><p><strong>Total price: </strong><strong class="total-price"></strong></p></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="place-order" class="btn btn-primary">Place the order</button>
            </div>
          </div>
        </div>
      </div>';
    } else {
      echo '<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Order Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Please login or create an account to finish setting up your order.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <a href="login.php" class="btn btn-primary btn-primary text-white p-2" type="submit">Sign-In</a>
            <a href="sign_up.php" class="btn btn-primary btn-primary text-white" type="submit">Create Account</a>
            </div>
          </div>
        </div>
      </div>';
    }
  } else {
    echo 
    '<div  class="container  d-flex flex-column  justify-content-center align-items-center" style=" height:600px; margin-top:50px !important; margin-bottom:50px !important">
    <h2 class="align-self-center">No items in your shopping cart</h2>
    <p class="align-self-center">Click the button bellow to begin shopping now</p>

    <a class="align-self-center btn-primary text-white bold p-3 rounded" href="./menu.php">Shopping Now</a>
    </p></div>';
  }
  ?>

  <?php include "components/footer.php"; ?>
</body>

</html>