<?php
require_once("Models/Product.php");
require_once("components/HeaderComponent.php");
require_once("components/NavbarComponent.php");
require_once("components/ProductComponent.php");
require_once("Models/Database.php");

$database = new Database();


$allProducts = $database->getAllProducts();

$searchWord = $_GET["q"] ?? "";

// SELECT * FROM product WHERE name LIKE :q OR description LIKE :q
$filteredProducts = $database->searchProducts($searchWord);

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
                <h1 class="display-4 fw-bolder">Recordstore</h1>
                <p class="lead fw-normal text-white-50 mb-0">Your home for vinyl</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Search Results for "<?php echo $searchWord; ?>":</h2>
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