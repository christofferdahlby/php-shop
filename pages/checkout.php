<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');

// ta carten
// redirecta till stripe

$database = new Database();
$cart = new Cart($database, session_id());
$cartItems = $cart->getItems();

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// Skapa en array av line items som Stripe API:et kräver

$lineitems = [];
foreach ($cartItems as $item) {
    array_push($lineitems, [
        "quantity" => $item->quantity,
        "price_data" => [
            "currency" => "sek",
            "unit_amount" => $item->productPrice * 100, // Stripe kräver pris i ören
            "product_data" => [
                "name" => $item->productName
            ]
        ]
    ]);
}

// Nu är lineitems arrayen klar att skickas till Stripe API:et
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost:8000/checkoutsuccess",
    "cancel_url" => "http://localhost:8000",
    "locale" => "auto",
    "line_items" => $lineitems
]);

http_response_code(303);
header("Location: " . $checkout_session->url);

echo "Checkout page coming soon!";

?>