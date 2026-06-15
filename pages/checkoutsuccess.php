<?php
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');
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

<body class="d-flex flex-column min-vh-100">
    <!-- Navigation-->
    <?php navbarComponent(); ?>

    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <h2 class="fw-bolder mb-4">Thank you for your purchase!</h2>
            <p>Your order has been successfully processed. We will send you a confirmation email shortly.</p>
            <a href="/" class="btn btn-primary mt-3">Continue Shopping</a>
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