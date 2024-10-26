<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../../database.php");

// Check if the customer ID is passed
if (isset($_POST['customerID'])) {
    $customerID = $_POST['customerID'];

  
function get_customer($customerID) {
    global $db;
    $query = 'SELECT * FROM customers WHERE customerID = :customerID';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->execute();
    $customer = $statement->fetch();
    $statement->closeCursor();
    return $customer;
}



    // If customer is found, redirect to the View/Update Customer page with customer data
    if ($customer) {
        // You can use a query string to pass customer details to the update page or session storage.
        header("Location: view_update_customer.php?customerID=" . $customer['customerID']);
        exit();
    } else {
        // Redirect back to customer search if no customer is found
        header("Location: customers.php?error=CustomerNotFound");
        exit();
    }
} else {
    // Redirect back if no customer ID is passed
    header("Location: customers.php");
    exit();
}

?>
