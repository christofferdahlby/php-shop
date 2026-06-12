<?php

require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');



$database = new Database();
$cart = new Cart($database, session_id());

$ruleId = $_GET['id'];

$freightRule = $database->getFreightRule($ruleId);
$freightCost = $cart->calculateFreightCost($freightRule);

echo json_encode([
    "cartItems" => $cart->getItems(),
    "cartTotalPrice" => $cart->getTotalPrice() + $freightCost,
    "cartTotalWeight" => $cart->getTotalWeight(),
    "freightCost" => $freightCost
]);


?>