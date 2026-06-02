<?php
ob_start();
session_start();
// session_id() ->> "a unique identifier for the session, which is used to retrieve the session data from the server. It is usually stored in a cookie on the client's browser, but can also be passed in the URL or as a hidden form field."
require_once(__DIR__ . '/Models/Database.php');
require_once(__DIR__ . '/utils/router.php');

$database = new Database();
// $cart = new Cart();

$router = new Router();
$router->addRoute('/', function () {
    require_once(__DIR__ . '/pages/index.php');
});
$router->addRoute('/product', function () {
    require_once(__DIR__ . '/pages/product.php');
});
$router->addRoute('/category', function () {
    require_once(__DIR__ . '/pages/category.php');
});
$router->addRoute('/admin', function () {
    require_once(__DIR__ . '/pages/admin.php');
});
$router->addRoute('/search', function () {
    require_once(__DIR__ . '/pages/search.php');
});
$router->addRoute('/addToCart', function () {
    require_once(__DIR__ . '/pages/addToCart.php');
});
$router->addRoute('/jsaddToCart', function () {
    require_once(__DIR__ . '/API/addToCart.php');
});
$router->addRoute('/removeFromCart', function () {
    require_once(__DIR__ . '/pages/removeFromCart.php');
});
$router->addRoute('/jsremoveFromCart', function () {
    require_once(__DIR__ . '/API/removeFromCart.php');
});
$router->addRoute('/javascriptFetchCart', function () {
    require_once(__DIR__ . '/API/fetchCart.php');
});
$router->addRoute('/viewCart', function () {
    require_once(__DIR__ . '/pages/viewCart.php');
});
$router->addRoute('/login', function () {
    require_once(__DIR__ . '/pages/login.php');
});
$router->addRoute('/register', function () {
    require_once(__DIR__ . '/pages/register.php');
});
$router->addRoute('/logout', function () {
    require_once(__DIR__ . '/pages/logout.php');
});
$router->addRoute('/prisjakt', function () {
    require_once(__DIR__ . '/integrations/prisjakt.php');
});
$router->dispatch();

?>