<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');

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

<body class="d-flex flex-column min-vh-100">

    <?php navbarComponent(); ?>
    <!-- Cart Content -->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">

            <?php if (count($cartItems) === 0): ?>

                <div class="text-center text-white py-5">

                    <h2 class="fw-normal mb-4">
                        Your cart is empty
                    </h2>

                    <img src="/assets/tom_skivback.webp" alt="Empty Record Crate" class="img-fluid mb-4" style="
                        width: 76px;
                        height: 76px;
                        object-fit: cover;
                        /* padding: 12px;
                        border: 4px solid #000; */
                        border-radius: 50%;
                    ">

                    <div>

                        <a href="/" class="btn btn-light px-4">

                            Continue Shopping

                        </a>

                    </div>

                </div>

            <?php else: ?>

                <div class="row g-4">

                    <!-- Cart Items -->
                    <div class="col-lg-8">

                        <div class="border-bottom border-secondary px-4 py-3 mb-3 ps-0" style="background-color:#111;">
                            <h3 class="mb-0 text-white fw-normal">
                                Shopping Cart
                            </h3>
                        </div>

                        <div class="d-flex flex-column gap-3" id="cartItemElement">

                            <!-- Cart items rendered by JavaScript -->

                        </div>

                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-4">

                        <div class="sticky-top" style="top: 120px;">

                            <div class="bg-black text-white py-3 p-4">

                                <div class="border-bottom border-secondary pb-3 mb-4">
                                    <h3 class="mb-0 text-white fw-normal">
                                        Order Summary
                                    </h3>
                                </div>

                                <div class="mb-3">
                                    <strong>Total Weight:</strong>
                                    <span id="cartTotalWeight">0</span> kg
                                </div>

                                <div class="mb-3">

                                    <label for="freightRulesSelect" class="form-label">
                                        Shipping Method
                                    </label>

                                    <select id="freightRulesSelect" class="form-select bg-dark text-white border-secondary">

                                        <option value="">
                                            Select shipping option
                                        </option>

                                        <?php foreach ($freightRules as $rule): ?>

                                            <option value="<?php echo $rule->id; ?>"
                                                data-basefee="<?php echo $rule->baseFee; ?>"
                                                data-weightmultiplier="<?php echo $rule->weightMultiplier; ?>">

                                                <?php echo htmlspecialchars($rule->zoneName); ?>
                                                -
                                                <?php echo $rule->baseFee; ?> SEK +
                                                <?php echo $rule->weightMultiplier; ?> SEK/kg

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="d-flex justify-content-between mb-2">

                                    <span>Shipping</span>
                                    <span id="freightCost">0 SEK</span>

                                </div>

                                <hr class="border-secondary">

                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <strong>Total</strong>

                                    <h4 class="mb-0">
                                        SEK
                                        <span id="cartTotalPrice">
                                            <?php echo number_format($totalPrice, 2); ?>
                                        </span>
                                    </h4>

                                </div>

                                <div class="d-grid gap-2">

                                    <a href="/checkout" class="btn btn-light">
                                        Proceed to Checkout
                                    </a>

                                    <a href="/" class="btn btn-outline-light">
                                        Continue Shopping
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endif; ?>

        </div>
    </section>

    <!-- Footer-->
    <?php footerComponent(); ?>

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