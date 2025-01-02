<!-- customers/add_customer.php -->

<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require('../database.php');

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
    $statement->bindValue(':password', ($password)); // Hash password for security
    
    $statement->execute();
    $statement->closeCursor();

    // Redirect to the manage customers page
    header("Location: manage_customers_form.php");
    exit();
} else {
    echo "Error: All required fields must be filled out.";
}
?>
