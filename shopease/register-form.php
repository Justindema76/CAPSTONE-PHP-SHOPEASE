<?php
// Display errors for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include database connection
require('database.php');

// Fetch countries from the database for the dropdown
$queryCountries = 'SELECT countryCode, countryName FROM countries ORDER BY countryName';
$statement = $db->prepare($queryCountries);
$statement->execute();
$countries = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Get form data
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
$emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_SPECIAL_CHARS);
$postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_SPECIAL_CHARS);
$countryCode = filter_input(INPUT_POST, 'countryCode', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

// Validate input
if ($firstName && $lastName && $emailAddress && $password) {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the user into the database
    $query = 'INSERT INTO customers
              (firstName, lastName, emailAddress, phone, address, city, state, postalCode, countryCode, password)
              VALUES
              (:firstName, :lastName, :emailAddress, :phone, :address, :city, :state, :postalCode, :countryCode, :password)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':emailAddress', $emailAddress);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':postalCode', $postalCode);
    $statement->bindValue(':countryCode', $countryCode);
    $statement->bindValue(':password', $hashedPassword);

    $statement->execute();
    $statement->closeCursor();

    // Get the ID of the newly inserted user
    $query = 'SELECT * FROM customers WHERE emailAddress = :emailAddress';
    $statement = $db->prepare($query);
    $statement->bindValue(':emailAddress', $emailAddress);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
 // Log in the user by storing their info in session variables
 if ($user) {
    $_SESSION['customerID'] = $user['customerID'];
    $_SESSION['firstName'] = $user['firstName'];
    $_SESSION['lastName'] = $user['lastName'];
    $_SESSION['emailAddress'] = $user['emailAddress'];

   // Check if there's a redirect URL stored in the session
        if (isset($_SESSION['redirect_after_login'])) {
            $redirectUrl = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']); // Clear the session variable after redirect
            header("Location: $redirectUrl");
        } else {
            // Redirect to the default page (e.g., home)
            header("Location: home.php");
        }
        exit();
}
} else {
echo "Error: All required fields must be filled out.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/shop.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

   <!-- Main Content -->
  
    <?php include("view/customer.php"); ?>



    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
