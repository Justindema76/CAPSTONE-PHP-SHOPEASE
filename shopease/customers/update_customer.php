<!--customers/update_customer.php -->

<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require('../database.php');

// Get form data
$customerID = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
$emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_SANITIZE_EMAIL);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_SPECIAL_CHARS);
$postalCode = filter_input(INPUT_POST, 'postalCode', FILTER_SANITIZE_SPECIAL_CHARS);
$countryCode = filter_input(INPUT_POST, 'countryCode', FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

// Validate customer ID and make sure other values are not empty
if ($customerID && $firstName && $lastName && $emailAddress) {
    $query = 'UPDATE customers
              SET firstName = :firstName,
                  lastName = :lastName,
                  emailAddress = :emailAddress,
                  city = :city,
                  address = :address,
                  state = :state,
                  postalCode = :postalCode,
                  countryCode = :countryCode,
                  phone = :phone,
                  password = :password
              WHERE customerID = :customerID';

    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':emailAddress', $emailAddress);
    $statement->bindValue(':city', $city);
    $statement->bindValue(':address', $address);
    $statement->bindValue(':state', $state);
    $statement->bindValue(':postalCode', $postalCode);
    $statement->bindValue(':countryCode', $countryCode);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':customerID', $customerID);
    
    $statement->execute();
    $statement->closeCursor();
    
    // Redirect back to the manage customers page
    header("Location: manage_customers_form.php");
    exit();
} else {
    echo "Error: Invalid input data.";
}
?>
