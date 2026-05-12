<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');

$database = new Database();
$cart = new Cart($database, session_id());
$cart->addItem($_GET['id'], 1);
// href="/addToCart?id echo $product->id &fromPage echo urlencode($_SERVER['REQUEST_URI']) i länken där man trycker på "add to cart" knappen

echo "Adding to cart...";

$fromPage = urldecode($_GET['fromPage'] ?? '/');
echo $fromPage;
header("Location: $fromPage");
?>