<?php
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');

$database = new Database();

$cart = new Cart($database, session_id());
$cart->clearCart();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Checkout Success"); ?>
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
            <h2 class="fw-bolder mb-4">Thank you for your purchase!</h2>
            <p>Your order has been successfully processed. We will send you a confirmation email shortly.</p>
            <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
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
    <script src="/js/scripts.js"></script>
</body>

</html>