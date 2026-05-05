<?php
require_once("Models/Database.php");
function navbarComponent()
{
    $database = new Database();
    $allCategories = $database->getAllCategories(); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="/index.php">Recordstore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Genres</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="category.php">All Genres</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <?php
                            foreach ($allCategories as $category) {
                                echo "<li><a class=\"dropdown-item\" href=\"category.php?genre=" . urlencode($category) . "\">$category</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#!">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Create account</a></li>
                </ul>
                <form method="get" action="search.php">
                    <div class="input-group">
                        <input name="q" class="form-control" type="search" placeholder="Search for..." aria-label="Search">
                        <button type="submit" class="btn btn-outline-secondary" id="button-search"
                            type="button">Go!</button>
                    </div>
                </form>
                <form class="d-flex ms-3">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <?php
} ?>