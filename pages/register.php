<?php
ob_start();

require_once(__DIR__ . '/../utils/Validator.php');
require_once(__DIR__ . '/../components/HeaderComponent.php');
require_once(__DIR__ . '/../components/NavbarComponent.php');
require_once(__DIR__ . '/../components/FooterComponent.php');
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

<body class="d-flex flex-column min-vh-100">

    <?php navbarComponent(); ?>

    <!-- Register Section -->
    <section class="py-5">

        <div class="container px-4 px-lg-5">

            <div class="row justify-content-center">

                <div class="col-lg-5">

                    <div class="p-4 text-white" style="background-color:#111;">

                        <h2 class="fw-normal mb-3">
                            Create Account
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
                                    name="email" placeholder="name@example.com"
                                    value="<?php echo htmlspecialchars($email); ?>" required>

                                <label for="email" class="text-secondary">
                                    Email address
                                </label>

                            </div>

                            <div class="text-danger small mb-3">
                                <?php echo $v->get_error_message('email'); ?>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">

                                <input type="password" class="form-control bg-dark text-white border-secondary"
                                    id="password" name="password" placeholder="Password" required>

                                <label for="password" class="text-secondary">
                                    Password
                                </label>

                            </div>

                            <div class="text-danger small mb-3">
                                <?php echo $v->get_error_message('password'); ?>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-3">

                                <input type="password" class="form-control bg-dark text-white border-secondary"
                                    id="confirm_password" name="confirm_password" placeholder="Repeat Password"
                                    required>

                                <label for="confirm_password" class="text-secondary">
                                    Repeat Password
                                </label>

                            </div>

                            <div class="text-danger small mb-3">
                                <?php echo $v->get_error_message('confirm_password'); ?>
                            </div>

                            <!-- Name -->
                            <div class="form-floating mb-3">

                                <input type="text" class="form-control bg-dark text-white border-secondary" id="name"
                                    name="name" placeholder="Name" value="<?php echo htmlspecialchars($name); ?>"
                                    required>

                                <label for="name" class="text-secondary">
                                    Full Name
                                </label>

                            </div>

                            <div class="text-danger small mb-3">
                                <?php echo $v->get_error_message('name'); ?>
                            </div>

                            <!-- Street -->
                            <div class="form-floating mb-3">

                                <input type="text" class="form-control bg-dark text-white border-secondary" id="street"
                                    name="street" placeholder="Street" value="<?php echo htmlspecialchars($street); ?>"
                                    required>

                                <label for="street" class="text-secondary">
                                    Street Address
                                </label>

                            </div>

                            <div class="text-danger small mb-3">
                                <?php echo $v->get_error_message('street'); ?>
                            </div>

                            <!-- Postal Code -->
                            <div class="form-floating mb-3">

                                <input type="text" class="form-control bg-dark text-white border-secondary"
                                    id="postal_code" name="postal_code" placeholder="Postal Code"
                                    value="<?php echo htmlspecialchars($postal_code); ?>" required>

                                <label for="postal_code" class="text-secondary">
                                    Postal Code
                                </label>

                            </div>

                            <div class="text-danger small mb-3">
                                <?php echo $v->get_error_message('postal_code'); ?>
                            </div>

                            <!-- City -->
                            <div class="form-floating mb-4">

                                <input type="text" class="form-control bg-dark text-white border-secondary" id="city"
                                    name="city" placeholder="City" value="<?php echo htmlspecialchars($city); ?>"
                                    required>

                                <label for="city" class="text-secondary">
                                    City
                                </label>

                            </div>

                            <div class="text-danger small mb-4">
                                <?php echo $v->get_error_message('city'); ?>
                            </div>

                            <div class="d-grid">

                                <button type="submit" class="btn btn-light btn-lg">

                                    Create Account

                                </button>

                            </div>

                        </form>

                        <hr class="border-secondary my-4">

                        <p class="text-secondary mb-2">
                            Already have an account?
                        </p>

                        <a href="/login" class="text-white text-decoration-none">

                            Login here

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Footer -->
    <?php footerComponent(); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core theme JS -->
    <script src="/js/scripts.js"></script>

</body>

</html>