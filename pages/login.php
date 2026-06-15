<?php
ob_start();

require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');
require_once(__DIR__ . '/../Models/Database.php');

$database = new Database();

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {

        $database->getUsersDatabase()->getAuth()->login($email, $password);

        header("Location: /");
        exit;

    } catch (\Delight\Auth\InvalidEmailException $e) {

        $message = "Wrong email or password.";

    } catch (\Delight\Auth\InvalidPasswordException $e) {

        $message = "Wrong email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Login"); ?>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php navbarComponent(); ?>

    <!-- Login Section -->
    <section class="py-5">

        <div class="container px-4 px-lg-5">

            <div class="row justify-content-center">

                <div class="col-lg-5">

                    <div class="p-4 text-white" style="background-color:#111;">

                        <h2 class="fw-normal mb-3">
                            Login
                        </h2>

                        <hr class="border-secondary mb-4">

                        <?php if ($message): ?>

                            <div class="alert alert-danger">
                                <?php echo $message; ?>
                            </div>

                        <?php endif; ?>

                        <form method="POST">

                            <!-- Email -->
                            <div class="form-floating mb-3">

                                <input type="email" class="form-control bg-dark text-white border-secondary" id="email"
                                    name="email" placeholder="name@example.com" required>

                                <label for="email" class="text-secondary">
                                    Email address
                                </label>

                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-4">

                                <input type="password" class="form-control bg-dark text-white border-secondary"
                                    id="password" name="password" placeholder="Password" required>

                                <label for="password" class="text-secondary">
                                    Password
                                </label>

                            </div>

                            <div class="d-grid">

                                <button class="btn btn-light btn-lg" type="submit">

                                    Login

                                </button>

                            </div>

                        </form>

                        <hr class="border-secondary my-4">

                        <div>

                            <a class="text-white text-decoration-none" href="#">

                                Lost password?

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Footer -->
    <?php footerComponent(); ?>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core theme JS -->
    <script src="/js/scripts.js"></script>

</body>

</html>