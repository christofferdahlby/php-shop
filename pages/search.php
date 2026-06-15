<?php
require_once(__DIR__ . '/../Models/Product.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/ProductComponent.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../components/SortingComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');

$database = new Database();

$sort = $_GET['sort'] ?? 'record_title';
$order = $_GET['order'] ?? 'asc';

$selectedOption = $sort . '-' . $order;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$productsPerPage = 8;
$offset = ($page - 1) * $productsPerPage;

$searchWord = $_GET["q"] ?? "";

$totalProducts = $database->getSearchProductCount($searchWord);
$totalPages = ceil($totalProducts / $productsPerPage);

$filteredProducts = $database->searchProducts(
    $searchWord,
    $sort,
    $order,
    $productsPerPage,
    $offset
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Search Results"); ?>
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation-->
    <?php navbarComponent(); ?>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <!-- Search Header -->
            <div class="border-bottom border-secondary mb-4 px-4 py-3 ps-0 pe-0" style="background-color:#111;">

                <!-- Sorting Component -->
                <?php
                sortingComponent(
                    'Search Results for "' . htmlspecialchars($searchWord) . '"',
                    $selectedOption
                );
                ?>

            </div>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                foreach ($filteredProducts as $product) {

                    productComponent($product);

                }
                ?>
            </div>
            <div class="d-flex justify-content-center mt-4">

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>

                    <a class="btn btn-dark mx-1 <?php echo $page === $i ? 'active' : ''; ?>"
                        href="?q=<?php echo urlencode($searchWord); ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>

                <?php endfor; ?>

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