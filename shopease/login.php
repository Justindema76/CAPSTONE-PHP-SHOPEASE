<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require('database.php');

// Initialize an error message variable
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $emailAddress = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($emailAddress && $password) {
        // Query to check user credentials
        $query = 'SELECT * FROM customers WHERE emailAddress = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $emailAddress);
        $statement->execute();
        $user = $statement->fetch();
        $statement->closeCursor();

        // Verify credentials
        if ($user && $user['password'] === $password) {
            // Start session and save user data
            session_start();
            $_SESSION['customerID'] = $user['customerID'];
            $_SESSION['emailAddress'] = $user['emailAddress'];
            $_SESSION['firstName'] = $user['firstName'];

            // Redirect to a logged-in page
            header("Location: home.php");
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Please fill out all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop.css">
</head>
<body>
    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <!-- login -->
    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Login</h2>
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action="login.php">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required />
                </div>
                <!-- Display error message if present -->
                <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-3"><?php echo $error_message; ?></div>
                <?php endif; ?>
                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" value="Login" />
                </div>
                <div class="form-group">
                    <a id="register-url" href="register-form.php" class="btn">Don't have an account? Register</a>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
