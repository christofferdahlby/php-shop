<?php
require_once(__DIR__ . '/../Models/Database.php');
require_once(__DIR__ . '/../Models/Cart.php');
require_once(__DIR__ . '/../Models/CartItem.php');
function navbarComponent()
{
    $database = new Database();
    $allCategories = $database->getAllCategories();

    $cart = new Cart($database, session_id());
    $cartItemCount = $cart->getItemsCount(); ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top py-3">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand fs-2" href="/">
                <img src="/assets/skivback.webp" class="rounded-circle border border-dark me-2"
                    style="width: 60px; height: 60px; object-fit: cover;">crate digger</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Genres</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="category">All Genres</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            foreach ($allCategories as $category) {
                                echo "<li><a class=\"dropdown-item\" href=\"category?genre=" . urlencode($category) . "\">$category</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <?php $database = new Database();
                    if (!$database->getUsersDatabase()->getAuth()->isLoggedIn()) { ?>
                        <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <?php } ?>
                    <?php $database = new Database();
                    if ($database->getUsersDatabase()->getAuth()->isLoggedIn()) { ?>
                        <li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>
                    <?php } ?>
                    <li class="nav-item"><a class="nav-link" href="/register">Create account</a></li>
                </ul>
                <form method="get" action="search">
                    <div class="input-group">
                        <input name="q" class="form-control" type="search" placeholder="Search for..." aria-label="Search">
                        <button type="submit" class="btn btn-outline-light" id="button-search" type="button">Go!</button>
                    </div>
                </form>
                <form class="d-flex ms-3">
                    <a href="/viewCart" class="btn btn-outline-light" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-danger text-white ms-1 rounded-pill"
                            id="cartItemCount"><?php echo $cartItemCount; ?></span>
                    </a>
                </form>
            </div>
        </div>
    </nav>

    <?php
} ?>