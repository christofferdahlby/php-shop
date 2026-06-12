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

// Hämta alla fraktregler
$freightRules = $database->getAllFreightRules();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent('Cart'); ?>
</head>

<body>

    <?php navbarComponent(); ?>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Your Shopping Cart</h1>
                <p class="lead fw-normal text-white-50 mb-0">
                    Review items before checkout
                </p>
            </div>
        </div>
    </header>

    <!-- Cart Content -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <?php if (count($cartItems) === 0): ?>

                <div class="alert alert-info">
                    Your cart is empty.
                    <a href="/">Continue shopping</a>.
                </div>

            <?php else: ?>

                <!-- Cart Items -->
                <div class="d-flex flex-column gap-4" id="cartItemElement">

                </div>

                <!-- Order Summary -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-body">

                        <h4 class="mb-4">Order Summary</h4>

                        <!-- Weight -->
                        <div class="mb-3">
                            <strong>Total Weight:</strong>
                            <span id="cartTotalWeight">0</span> kg
                        </div>

                        <!-- Freight Selection -->
                        <div class="mb-3">
                            <label for="freightRulesSelect" class="form-label">
                                Shipping Method
                            </label>

                            <select id="freightRulesSelect" class="form-select">
                                <option value="">
                                    Select shipping option
                                </option>

                                <?php foreach ($freightRules as $rule): ?>
                                    <option value="<?php echo $rule->id; ?>" data-basefee="<?php echo $rule->baseFee; ?>"
                                        data-weightmultiplier="<?php echo $rule->weightMultiplier; ?>">

                                        <?php echo htmlspecialchars($rule->zoneName); ?>
                                        -
                                        <?php echo $rule->baseFee; ?> SEK +
                                        <?php echo $rule->weightMultiplier; ?> SEK/kg

                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- Shipping Cost -->
                        <div class="mb-3">
                            <strong>Shipping:</strong>
                            <span id="freightCost">0</span> SEK
                        </div>

                        <!-- Total -->
                        <div class="mb-3">
                            <h4>
                                Total:
                                SEK <span id="cartTotalPrice">
                                    <?php echo number_format($totalPrice, 2); ?>
                                </span>
                            </h4>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">

                            <a class="btn btn-outline-dark" href="/">
                                Continue Shopping
                            </a>

                            <a href="/checkout" class="btn btn-primary btn-lg">
                                Proceed to Checkout
                            </a>

                        </div>

                    </div>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">
                Copyright &copy; Your Shop 2025
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>

    <script>

        document.addEventListener("DOMContentLoaded", async function () {

            const data = await fetchCartItems();

            drawCart(
                data.cartItems,
                data.cartTotalPrice,
                data.cartTotalWeight,
                data.freightCost
            );

        });

        const freightRulesSelect = document.getElementById('freightRulesSelect');
        freightRulesSelect.addEventListener('change', function () {
            const selectedFreightRuleId = this.value;

            if (selectedFreightRuleId) {

                fetch(`/calculateCartWithFreight?id=${selectedFreightRuleId}`)
                    .then(response => response.json())
                    .then(data => {
                        drawCart(data.cartItems, data.cartTotalPrice, data.cartTotalWeight, data.freightCost);
                    });
            }
        });



    </script>

</body>

</html>