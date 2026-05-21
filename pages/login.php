<?php
ob_start();

require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
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

<body>

    <?php navbarComponent(); ?>

    <!-- Header -->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Recordstore</h1>
                <p class="lead fw-normal text-white-50 mb-0">
                    Your home for vinyl
                </p>
            </div>
        </div>
    </header>

    <!-- Login Section -->
    <section class="py-5">

        <div class="container px-4 px-lg-5">

            <div class="row justify-content-center">

                <div class="col-lg-5">

                    <div class="card shadow border-0 rounded-4">

                        <div class="card-body p-5">

                            <h2 class="fw-bolder text-center mb-4">
                                Login
                            </h2>

                            <?php if ($message): ?>

                                <div class="alert alert-danger">
                                    <?php echo $message; ?>
                                </div>

                            <?php endif; ?>

                            <form method="POST">

                                <div class="form-floating mb-3">

                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="name@example.com" required>

                                    <label for="email">
                                        Email address
                                    </label>

                                </div>

                                <div class="form-floating mb-4">

                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>

                                    <label for="password">
                                        Password
                                    </label>

                                </div>

                                <div class="d-grid">

                                    <button class="btn btn-dark btn-lg" type="submit">
                                        Login
                                    </button>

                                </div>

                            </form>

                            <div class="text-center mt-4">

                                <a class="text-decoration-none" href="#">
                                    Lost password?
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Footer -->
    <footer class="py-5 bg-dark">

        <div class="container">

            <p class="m-0 text-center text-white">
                Copyright &copy; Recordstore 2025
            </p>

        </div>

    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core theme JS -->
    <script src="/js/scripts.js"></script>

</body>

</html>