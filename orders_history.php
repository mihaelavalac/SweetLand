<?php
include("global/mysql.php");
include("classes/orders.class.php");
include("classes/user.class.php");
include("classes/menu_items.class.php");
include("classes/ordered_items.class.php");

//Get User ID
$user = new User();
$user_info = $user->getUserInfo($conn, $_SESSION['email']);
$user_id = $user_info[0]['id'];
$f_name = $user_info[0]['first_name']; 

$order = new Orders();
$orders = $order->getOrders($conn, $user_id);

$order_items = new OrderedItems();
$menu_items = new MenuItems();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "head.php"; ?>
  <title>Shopping Cart</title>
</head>

<body>
  <?php include "components/nav_bar.php" ?>

  <div class=" container mt-3 mb-3" style=" min-height:600px; margin-top:50px !important; margin-bottom:50px !important">
    <h1>Orders History</h1>


    <div class="accordion p-2" id="accordionFlushExample">

      <?php
      foreach (array_reverse($orders) as $listRow) {
        $order_id = $listRow['id'];
        $order_status = $listRow['status'];
        $ordered_date = date("m/d", strtotime($listRow['ordered_date']));
        $processed_date = date("m/d", strtotime($ordered_date . '+ 1 days'));
        $delivery_date = date("m/d", strtotime($ordered_date . '+ 3 days'));
        $all_items = $order_items->getOrderedItems($conn, $order_id);
        $finalPrice = 0;
        foreach ($all_items as $listRow) {
          $item_id = $listRow['item_id'];
          $item_quantity = (int) $listRow['quantity'];
          $item_price = (int) $listRow['price'];
          $subtotal = $item_quantity * $item_price;
          $finalPrice += $subtotal;
        }

        echo
        '<div class="accordion-item b-1">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-' . $order_id . '" aria-expanded="false" aria-controls="panelsStayOpen-' . $order_id . '">
                    <div class="col-md-12 bg-white">
                      <div class="px-3">
                      <div class="row">
                      <div class="col">
                      <strong>Order ' . $order_id . '</strong> 
                      </div>
                      <div class="col text-end">
                      <strong>Total: $' . $finalPrice . ' </strong>
                      </div>
                    </div>
                        <div class="d-flex flex-row justify-content-between align-items-center order">
                            <div class="d-flex flex-column order-details">
                              <span class="">Status:' . $order_status . ' </span>
                            </div>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center align-content-center">
                            <span class="dot"></span>
                            <hr class="flex-fill track-line"><span class="dot"></span>
                            <hr class="flex-fill track-line"><span class="d-flex justify-content-center align-items-center big-dot dot">
                            <i class="fa fa-check text-white"></i></span>
                        </div>
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="d-flex flex-column align-items-end"><span>' .  $ordered_date . '</span><span>Order placed</span></div>
                            <div class="d-flex flex-column justify-content-center align-items-center"><span>' . $processed_date . '</span><span>Order Processed</span></div>
                            <div class="d-flex flex-column align-items-end"><span>' . $delivery_date . '</span><span>Delivered</span></div>
                        </div>                        
                      </div>
                    </div>
                  </button> 
                  </div></span>';
        foreach ($all_items as $listRow) {
          $item_id = $listRow['item_id'];
          $item_quantity = (int) $listRow['quantity'];
          $item_price = (int) $listRow['price'];
          $item_info = $menu_items->getFavoriteOrOrderedItems($conn, $item_id);
          $item_img = $item_info[0]['image'];
          $item_name = $item_info[0]['name'];
          $subtotal = $item_quantity * $item_price;
          echo '
                      <div id="panelsStayOpen-' . $order_id . '" class="accordion-collapse collapse bg-secondary " aria-labelledby="panelsStayOpen-' . $order_id . '">
                        <div class="accordion-body "> 
                            <div class=" row text-center">
                                <div class="col"><img src="./' . $item_img . '" class="img-sm"></div>
                                <div class="col"><p class="title text-dark" data-abc="true">' . $item_name . '</p></div>
                                <div class="col"> <var class="quantity">' . $item_quantity . '</var></div>
                                <div class="col"> <var class="price">$' . $item_price . '</var></div>
                                <div class="col"> <var class="price">$' . $subtotal . '</var></div>
                            </div>
                        </div>
                      </div>';
        };;
      };
      ?>
    </div>
  </div>
  <?php include("./components/footer.php") ?>
</body>

</html>