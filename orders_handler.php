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

//Generate the order number and return it for a user.
$order = new Orders();
$generated_order_nr = ($order->add_order($conn, $user_id));
$orders = $order -> getOrders($conn,$user_id);

//Item ID and Quantity from GET
//Item price from DB
$order_items = json_decode($_GET['orders'], true);
$menu_obj = new MenuItems();
$ordered_item = new OrderedItems();

foreach ($order_items as $item) {
    $item_id =  $item[0];
    $item_price = $menu_obj->getItemPrice($conn, $item_id);
    $item_quantity =  $item[1];
    $add_ordered_item = $ordered_item->addOrderedItems($conn,$item_id, $generated_order_nr, $item_price[0], $item_quantity);
};
?>
<?php
header( 'Location:orders_history.php');
?>

