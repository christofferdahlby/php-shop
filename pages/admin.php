<?php
require_once(__DIR__ . '/../Models/Product.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');

$database = new Database();
$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $price = $_POST['price'];
    $stockLevel = $_POST['stockLevel'];

    $validatedPrice = filter_var($price, FILTER_VALIDATE_FLOAT);
    $validatedStock = filter_var($stockLevel, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0]
    ]);

    if ($validatedPrice !== false && $validatedStock !== false && $productId) {
        $updated = $database->updateProductPriceAndStock($productId, $validatedPrice, $validatedStock);
        if ($updated !== false) {
            $message = "Product #$productId updated successfully.";
        } else {
            $message = "Unable to update product. Please try again.";
        }
    } else {
        $message = "Please provide a valid price and stock level.";
    }
}

$allProducts = $database->getAllProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Admin"); ?>
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
            <?php if ($message): ?>
                <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($allProducts as $product): ?>
                        <tr>
                            <form method="post">
                                <td><?php echo htmlspecialchars($product->record_title); ?></td>
                                <td><?php echo htmlspecialchars($product->artist); ?></td>
                                <td><?php echo htmlspecialchars($product->genre); ?></td>
                                <td>
                                    <input type="number" step="0.01" min="0" name="price" class="form-control"
                                        value="<?php echo htmlspecialchars($product->price); ?>" required>
                                </td>
                                <td>
                                    <input type="number" step="1" min="0" name="stockLevel" class="form-control"
                                        value="<?php echo htmlspecialchars($product->stockLevel); ?>" required>
                                </td>
                                <td>
                                    <input type="hidden" name="product_id"
                                        value="<?php echo htmlspecialchars($product->id); ?>">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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