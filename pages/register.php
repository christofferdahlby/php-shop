<?php
ob_start();

require_once(__DIR__ . '/../utils/Validator.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../Models/Database.php');

$v = new Validator($_POST);

$database = new Database();

$message = "";

$email = "";
$password = "";
$confirm_password = "";
$name = "";
$street = "";
$postal_code = "";
$city = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $street = $_POST['street'];
    $postal_code = $_POST['postal_code'];
    $city = $_POST['city'];

    // Validation
    $v->field('email')->required()->email();
    $v->field('password')->required()->min_len(8)->max_len(20);
    $v->field('confirm_password')->equals($password);

    $v->field('name')->required()->min_len(3)->max_len(50);
    $v->field('street')->required()->min_len(3)->max_len(50);
    $v->field('postal_code')->required()->max_len(10);
    $v->field('city')->required()->max_len(50);

    if ($v->is_valid()) {

        try {

            $userid = $database
                ->getUsersDatabase()
                ->getAuth()
                ->register($email, $password, $email);

            $database->saveUserDetails(
                $userid,
                $name,
                $street,
                $postal_code,
                $city
            );

            header("Location: /login");
            exit;

        } catch (\Delight\Auth\UserAlreadyExistsException $e) {

            $message = "User already exists.";

        } catch (\Delight\Auth\InvalidEmailException $e) {

            $message = "Invalid email address.";

        } catch (\Delight\Auth\TooManyRequestsException $e) {

            $message = "Too many requests. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php headerComponent("Register"); ?>
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

    <!-- Register Section -->
    <section class="py-5">

        <div class="container px-4 px-lg-5">

            <div class="row justify-content-center">

                <div class="col-lg-6">

                    <div class="card shadow border-0 rounded-4">

                        <div class="card-body p-5">

                            <h2 class="fw-bolder text-center mb-4">
                                Create Account
                            </h2>

                            <?php if ($message): ?>

                                <div class="alert alert-danger">
                                    <?php echo $message; ?>
                                </div>

                            <?php endif; ?>

                            <form method="POST">

                                <!-- Email -->
                                <div class="form-floating mb-3">

                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="name@example.com" value="<?php echo htmlspecialchars($email); ?>"
                                        required>

                                    <label for="email">
                                        Email address
                                    </label>

                                </div>

                                <div class="text-danger small mb-3">
                                    <?php echo $v->get_error_message('email'); ?>
                                </div>

                                <!-- Password -->
                                <div class="form-floating mb-3">

                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>

                                    <label for="password">
                                        Password
                                    </label>

                                </div>

                                <div class="text-danger small mb-3">
                                    <?php echo $v->get_error_message('password'); ?>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-floating mb-3">

                                    <input type="password" class="form-control" id="confirm_password"
                                        name="confirm_password" placeholder="Repeat Password" required>

                                    <label for="confirm_password">
                                        Repeat Password
                                    </label>

                                </div>

                                <div class="text-danger small mb-3">
                                    <?php echo $v->get_error_message('confirm_password'); ?>
                                </div>

                                <!-- Name -->
                                <div class="form-floating mb-3">

                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                                        value="<?php echo htmlspecialchars($name); ?>" required>

                                    <label for="name">
                                        Full Name
                                    </label>

                                </div>

                                <div class="text-danger small mb-3">
                                    <?php echo $v->get_error_message('name'); ?>
                                </div>

                                <!-- Street -->
                                <div class="form-floating mb-3">

                                    <input type="text" class="form-control" id="street" name="street"
                                        placeholder="Street" value="<?php echo htmlspecialchars($street); ?>" required>

                                    <label for="street">
                                        Street Address
                                    </label>

                                </div>

                                <div class="text-danger small mb-3">
                                    <?php echo $v->get_error_message('street'); ?>
                                </div>

                                <!-- Postal Code -->
                                <div class="form-floating mb-3">

                                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                                        placeholder="Postal Code" value="<?php echo htmlspecialchars($postal_code); ?>"
                                        required>

                                    <label for="postal_code">
                                        Postal Code
                                    </label>

                                </div>

                                <div class="text-danger small mb-3">
                                    <?php echo $v->get_error_message('postal_code'); ?>
                                </div>

                                <!-- City -->
                                <div class="form-floating mb-4">

                                    <input type="text" class="form-control" id="city" name="city" placeholder="City"
                                        value="<?php echo htmlspecialchars($city); ?>" required>

                                    <label for="city">
                                        City
                                    </label>

                                </div>

                                <div class="text-danger small mb-4">
                                    <?php echo $v->get_error_message('city'); ?>
                                </div>

                                <!-- Submit -->
                                <div class="d-grid">

                                    <button type="submit" class="btn btn-dark btn-lg">
                                        Create Account
                                    </button>

                                </div>

                            </form>

                            <div class="text-center mt-4">

                                <p class="mb-0">
                                    Already have an account?
                                </p>

                                <a href="/login" class="text-decoration-none">
                                    Login here
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core theme JS -->
    <script src="/js/scripts.js"></script>

</body>

</html>