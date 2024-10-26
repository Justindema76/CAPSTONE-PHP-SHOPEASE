<?php

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require('../../database.php');

// Get the customer ID from the form submission
$customerID = filter_input(INPUT_POST, 'customerID', FILTER_VALIDATE_INT);

if ($customerID !== null && $customerID !== false) {
    
    // Fetch customer data
    $queryCustomer = 'SELECT * FROM customers WHERE customerID = :customerID';
    $statement = $db->prepare($queryCustomer);
    $statement->bindValue(':customerID', $customerID);
    $statement->execute();
    
    $customer = $statement->fetch();  
    $statement->closeCursor();
    
    // Check if customer was found
    if (!$customer) {
        echo 'No customer found with the provided ID.';
        exit();
    }
} else {
    echo 'Invalid customer ID.';
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View/Update Customer</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
    <?php include '../../view/admin_sidebar.php'; ?>
    
    <main>
        <h2>View/Update Customer</h2>
        
        <form action="update_customer.php" method="post" id="add_product_form">
            <!-- Hidden field for customerID -->
            <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>" />
            
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" value="<?php echo htmlspecialchars($customer['firstName']); ?>" /><br>

            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" value="<?php echo htmlspecialchars($customer['lastName']); ?>" /><br>

            <label for="emailAddress">Email Address:</label>
            <input type="text" name="emailAddress" value="<?php echo htmlspecialchars($customer['emailAddress']); ?>" /><br>

            <label for="line1">Address Line 1:</label>
            <input type="text" name="line1" value="<?php echo htmlspecialchars($customer['line1']); ?>" /><br>

            <label for="city">City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>" /><br>

            <label for="province">Province:</label>
            <input type="text" name="province" value="<?php echo htmlspecialchars($customer['province']); ?>" /><br>

            <label for="postalCode">Postal Code:</label>
            <input type="text" name="postalCode" value="<?php echo htmlspecialchars($customer['postalCode']); ?>" /><br>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" /><br>

            <label for="password">Password:</label>
            <input type="text" name="password" value="<?php echo htmlspecialchars($customer['password']); ?>" /><br>

            <!-- Update customer button -->
            <div id="buttons">
                <input type="submit" value="Update Customer" class="submit-button"/><br />
            </div>
        </form>

    </main>
    
  
</body>
</html>
