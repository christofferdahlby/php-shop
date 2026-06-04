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
                <div class="d-flex flex-column gap-4" id="cartItemElement">



                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <a class="btn btn-outline-dark" href="/">Continue shopping</a>
                    </div>
                    <div class="text-end">
                        <h4>Total: SEK <span id="cartTotalPrice"><?php echo number_format($totalPrice, 2); ?></span></h4>
                        <a href="/checkout" class="btn btn-primary btn-lg mt-2">Proceed to checkout</a>
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
    <script>
        // när sidan laddas så rendera cart items i tabellen
        document.addEventListener("DOMContentLoaded", async function () {
            const data = await fetchCartItems();
            drawCart(data.cartItems, data.cartTotalPrice);
        });
    </script>
</body>

</html>