<?php
require_once("Models/Product.php");
require_once("components/HeaderComponent.php");
require_once("components/NavbarComponent.php");
require_once("components/ProductComponent.php");
require_once("Models/Database.php");

$database = new Database();

// Get product ID from URL parameter
$productId = isset($_GET['id']) ? $_GET['id'] : null;
$product = null;

if ($productId) {
    $product = $database->getProduct($productId);
}

$allProducts = $database->getAllProducts();
$allCategories = $database->getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Home"); ?>
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
            <?php if ($product): ?>
                <!-- Single Product View -->
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-6">
                        <img class="img-fluid"
                            src="<?php echo $product->imageUrl ? $product->imageUrl : "https://dummyimage.com/450x300/dee2e6/6c757d.jpg"; ?>"
                            alt="<?php echo $product->record_title; ?>" />
                    </div>
                    <div class="col-md-6">
                        <h1><?php echo $product->record_title; ?></h1>
                        <p class="text-muted fs-5">By <?php echo $product->artist; ?></p>
                        <div class="fs-5 mb-5">
                            <span class="badge bg-dark">Genre: <?php echo $product->genre; ?></span>
                            <span class="badge bg-dark">Released: <?php echo $product->release_year; ?></span>
                        </div>
                        <p><?php echo $product->description; ?></p>
                        <div class="fs-3 fw-bold text-dark mb-4">SEK <?php echo $product->price; ?></div>
                        <div class="mb-3">
                            <small class="text-muted">Stock Level: <?php echo $product->stockLevel; ?></small>
                        </div>
                        <div>
                            <button class="btn btn-primary btn-lg">Add to Cart</button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- All Products Grid -->
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <?php
                    foreach ($allProducts as $p) {
                        productComponent($p);
                    }
                    ?>
                </div>
            <?php endif; ?>
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