<?php
require_once(__DIR__ . '/../Models/Product.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/ProductComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../utils/router.php');

$database = new Database();

$sort = $_GET['sort'] ?? 'record_title';
$order = $_GET['order'] ?? 'asc';

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$productsPerPage = 8;
$offset = ($page - 1) * $productsPerPage;

$totalProducts = $database->getTotalProductCount();
$totalPages = ceil($totalProducts / $productsPerPage);

$popularProducts = $database->getPopularProducts();
$allProducts = $database->getAllProducts($sort, $order, $productsPerPage, $offset);
$allCategories = $database->getAllCategories();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Home"); ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation-->
    <?php navbarComponent(); ?>
    <section class="position-relative d-flex align-items-center justify-content-center" style="
        height: calc(100vh - 76px);
        background-image: url('/assets/vinyl_hero.jpeg');
        background-size: cover;
        background-position: center;
    ">

        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.45);">
        </div>

        <div class="position-relative text-center text-white">

            <h1 class="display-2 fw-light">
                Crate Digger
            </h1>

            <p class="lead mb-4">
                For Those Who Still Dig.
            </p>

            <a href="#popular-products" class="btn btn-light btn-lg">
                Browse Records
            </a>

        </div>

    </section>
    <!-- Section-->
    <section id="popular-products" class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <!-- <div class="bg-black text-white p-3 mb-4">
                <h2 class="fw-bolder mb-4">Popular Products</h2>
            </div> -->
            <div class="border-bottom border-secondary text-white px-4 py-3 mb-4 ps-0 pe-0"
                style="background-color:#111;">
                <h2 class="mb-0 fw-normal">
                    Popular Products
                </h2>
            </div>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($popularProducts as $product) {

                    productComponent($product);

                }
                ?>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <?php footerComponent(); ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="/js/scripts.js"></script>
</body>

</html>