<?php
require_once("Models/Product.php");
require_once("components/HeaderComponent.php");
require_once("components/NavbarComponent.php");
require_once("components/ProductComponent.php");

$allProducts = getAllProducts();

$searchWord = $_GET["q"] ?? "";

$filteredProducts = array_filter($allProducts, function ($product) use ($searchWord) {
    return stripos($product->title, $searchWord) !== false;
});

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Search Results"); ?>
</head>

<body>
    <!-- Navigation-->
    <?php navbarComponent(); ?>
    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Super shoppen</h1>
                <p class="lead fw-normal text-white-50 mb-0">Handla massa onödigt hos oss!</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($filteredProducts as $product) {

                    productComponent($product);

                }
                ?>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Shop 2025</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>