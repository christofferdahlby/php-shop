<?php

require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');

$productIdToRemove = $_GET['id'];

$database = new Database();
$cart = new Cart($database, session_id());
$cart->removeItem($productIdToRemove, 1);



echo json_encode([
    'success' => true,
    'message' => "Product $productIdToRemove removed from cart",
    'cartItemCount' => $cart->getItemsCount(),
    'cartTotalPrice' => $cart->getTotalPrice(),
    'cartTotalWeight' => $cart->getTotalWeight(),
    "cartItems" => $cart->getItems(),
]);


?>