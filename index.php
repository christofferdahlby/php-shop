<?php
require_once(__DIR__ . '/Models/Database.php');
require_once(__DIR__ . '/utils/router.php');

$database = new Database();

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
$router->dispatch();

?>