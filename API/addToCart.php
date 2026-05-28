<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');

$database = new Database();
$cart = new Cart($database, session_id());
$cart->addItem($_GET['id'], 1);


echo json_encode([
    'success' => true,
    'message' => 'Item added to cart',
    'cartItemCount' => $cart->getItemsCount(),
    'cartTotalPrice' => $cart->getTotalPrice(),
    'cartItems' => $cart->getItems()
]);

/* $fromPage = urldecode($_GET['fromPage'] ?? '/');
echo $fromPage;
header("Location: $fromPage"); */
?>