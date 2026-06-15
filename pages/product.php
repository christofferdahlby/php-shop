<?php
require_once(__DIR__ . '/../Models/Product.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');

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

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation -->
    <?php navbarComponent(); ?>
    <!-- Section -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <?php if ($product): ?>

                <div class="row gx-0 justify-content-center bg-black text-white shadow">

                    <!-- Image -->
                    <div class="col-md-4">
                        <img class="img-fluid w-100 h-100 rounded-0" style="object-fit: cover;"
                            src="<?php echo $product->imageUrl ?: 'https://dummyimage.com/600x600/000/fff'; ?>"
                            alt="<?php echo htmlspecialchars($product->record_title); ?>">
                    </div>

                    <!-- Info -->
                    <div class="col-md-8 p-5">

                        <h1 class="mb-2">
                            <?php echo htmlspecialchars($product->record_title); ?>
                        </h1>

                        <p class="text-secondary fs-5 mb-4">
                            <?php echo htmlspecialchars($product->artist); ?>
                        </p>

                        <div class="mb-4">

                            <span class="badge text-bg-secondary me-2">
                                <?php echo htmlspecialchars($product->genre); ?>
                            </span>

                            <span class="badge text-bg-secondary">
                                <?php echo htmlspecialchars($product->release_year); ?>
                            </span>

                        </div>

                        <p class="mb-4">
                            <?php echo htmlspecialchars($product->description); ?>
                        </p>

                        <div class="fs-3 mb-3">
                            SEK
                            <?php echo $product->price; ?>
                        </div>

                        <p class="text-secondary mb-4">
                            Stock:
                            <?php echo $product->stockLevel; ?>
                        </p>

                        <a class="btn btn-light" onclick="jsaddToCart(<?php echo $product->id; ?>)">
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
    <?php footerComponent(); ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>