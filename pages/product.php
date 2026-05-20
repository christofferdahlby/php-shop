<?php
require_once(__DIR__ . '/../Models/Product.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');

$database = new Database();

// Get product ID from URL
$productId = $_GET['id'] ?? null;
$product = null;

if ($productId) {
    $product = $database->getProduct($productId);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent($product ? $product->record_title : "Product"); ?>
</head>

<body>
    <!-- Navigation -->
    <?php navbarComponent(); ?>

    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Recordstore</h1>
                <p class="lead fw-normal text-white-50 mb-0">Your home for vinyl</p>
            </div>
        </div>
    </header>

    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <?php if ($product): ?>

                <div class="row gx-4 gx-lg-5 justify-content-center">

                    <!-- Image -->
                    <div class="col-md-6">
                        <img class="img-fluid rounded"
                            src="<?php echo $product->imageUrl ?: 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg'; ?>"
                            alt="<?php echo htmlspecialchars($product->record_title); ?>">
                    </div>

                    <!-- Info -->
                    <div class="col-md-6">
                        <h1 class="mb-2"><?php echo htmlspecialchars($product->record_title); ?></h1>

                        <p class="text-muted fs-5">
                            By <?php echo htmlspecialchars($product->artist); ?>
                        </p>

                        <div class="mb-3">
                            <span class="badge bg-dark">
                                Genre: <?php echo htmlspecialchars($product->genre); ?>
                            </span>
                            <span class="badge bg-dark">
                                Released: <?php echo htmlspecialchars($product->release_year); ?>
                            </span>
                        </div>

                        <!-- <p><?php echo htmlspecialchars($product->description); ?></p> -->

                        <div class="fs-3 fw-bold mb-3">
                            SEK <?php echo $product->price; ?>
                        </div>

                        <p class="text-muted">
                            Stock: <?php echo $product->stockLevel; ?>
                        </p>

                        <a class="btn btn-primary btn-lg"
                            href="/addToCart?id=<?php echo $product->id; ?>&fromPage=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
                            Add to Cart
                        </a>
                    </div>

                </div>

            <?php else: ?>

                <div class="alert alert-warning text-center">
                    Product not found.
                </div>

            <?php endif; ?>

        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">
                Copyright &copy; Your Shop 2025
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>