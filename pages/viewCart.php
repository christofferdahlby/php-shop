<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');

$database = new Database();
$cart = new Cart($database, session_id());
$cartItems = $cart->getItems();
$totalPrice = $cart->getTotalPrice();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent('Cart'); ?>
</head>

<body>
    <!-- Navigation-->
    <?php navbarComponent(); ?>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Your Shopping Cart</h1>
                <p class="lead fw-normal text-white-50 mb-0">Review items before checkout</p>
            </div>
        </div>
    </header>

    <!-- Cart Content -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <?php if (count($cartItems) === 0): ?>
                <div class="alert alert-info">Your cart is empty. <a href="/">Continue shopping</a>.</div>
            <?php else: ?>
                <div class="d-flex flex-column gap-4">

                    <?php foreach ($cartItems as $item): ?>

                        <div class="card shadow-sm border-0">
                            <div class="card-body">

                                <div class="row align-items-center">

                                    <!-- Product image -->
                                    <div class="col-md-2 text-center">
                                        <img src="<?php echo htmlspecialchars($item->imageUrl); ?>"
                                            alt="<?php echo htmlspecialchars($item->productName); ?>" class="img-fluid rounded"
                                            style="max-height: 140px; object-fit: cover;">
                                    </div>

                                    <!-- Product info -->
                                    <div class="col-md-7">

                                        <h4 class="mb-1">
                                            <?php echo htmlspecialchars($item->productName); ?>
                                        </h4>

                                        <p class="text-muted mb-3">
                                            <?php echo htmlspecialchars($item->artist); ?>
                                        </p>

                                        <div class="d-flex gap-4">

                                            <div>
                                                <small class="text-muted d-block">Quantity</small>
                                                <strong>
                                                    <?php echo htmlspecialchars($item->quantity); ?>
                                                </strong>
                                            </div>

                                            <div>
                                                <small class="text-muted d-block">Unit price</small>
                                                <strong>
                                                    SEK <?php echo number_format($item->productPrice, 2); ?>
                                                </strong>
                                            </div>

                                            <div>
                                                <small class="text-muted d-block">Total</small>
                                                <strong>
                                                    SEK <?php echo number_format($item->rowPrice, 2); ?>
                                                </strong>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="col-md-3 text-md-end mt-4 mt-md-0">

                                        <a class="btn btn-dark w-100 mb-2"
                                            href="/addToCart?id=<?php echo urlencode($item->productId); ?>&fromPage=/viewCart">
                                            Add one
                                        </a>

                                        <a class="btn btn-outline-secondary w-100"
                                            href="/product?id=<?php echo urlencode($item->productId); ?>">
                                            View product
                                        </a>

                                    </div>

                                </div>

                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <a class="btn btn-outline-dark" href="/">Continue shopping</a>
                    </div>
                    <div class="text-end">
                        <h4>Total: SEK <?php echo number_format($totalPrice, 2); ?></h4>
                        <a class="btn btn-primary btn-lg mt-2" href="#">Proceed to checkout</a>
                    </div>
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