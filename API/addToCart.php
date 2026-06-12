<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');

$productIdToAddToCart = $_GET['id'];

$database = new Database();
$cart = new Cart($database, session_id());
$cart->addItem($productIdToAddToCart, 1);
// READ CART FROM DATABASE AGAIN TO GET UPDATED CART ITEMS, TOTAL PRICE AND TOTAL WEIGHT
$cart = new Cart($database, session_id());

$freightRuleId = $_GET['freightRuleId'] ?? null; // Om freightRuleId inte skickas med i URL:en så sätt den till null
if ($freightRuleId && $freightRuleId !== 'null') {
    $freightRule = $database->getFreightRule($freightRuleId);
    $freightCost = $cart->calculateFreightCost($freightRule);
} else {
    $freightCost = 0;
}

echo json_encode([
    'success' => true,
    'message' => 'Item added to cart',
    'cartItemCount' => $cart->getItemsCount(),
    'cartTotalPrice' => $cart->getTotalPrice() + $freightCost,
    'cartTotalWeight' => $cart->getTotalWeight(),
    'freightCost' => $freightCost,
    'cartItems' => $cart->getItems()
]);

/* $fromPage = urldecode($_GET['fromPage'] ?? '/');
echo $fromPage;
header("Location: $fromPage"); */
?>