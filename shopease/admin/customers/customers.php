<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("../../database.php");

// Initialize lastName variable and customers array
$lastName = '';
$customers = [];

// Base query to fetch all customers
$queryCustomers = 'SELECT * FROM customers';

try {
    // Check if a last name was submitted
    if (isset($_POST['last_name']) && !empty(trim($_POST['last_name']))) {
        $lastName = trim($_POST['last_name']);
        // Modify query to search customers by last name
        $queryCustomers .= ' WHERE lastName LIKE :lastName';
    }

    // Prepare the query
    $statement1 = $db->prepare($queryCustomers);

    // Bind value only if lastName is set
    if (!empty($lastName)) {
        $statement1->bindValue(':lastName', '%' . $lastName . '%');
    }

    // Execute the query
    $statement1->execute();
    // Fetch all customers
    $customers = $statement1->fetchAll();  
    $statement1->closeCursor();
} catch (PDOException $e) {
    echo "Error fetching customers: " . $e->getMessage();
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
    <?php include '../../view/admin_sidebar.php'; ?>
    <main>
        <h2>Customer Search</h2>
        <form action="customers.php" method="post">
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($lastName); ?>"/>
            <input type="submit" value="Search">
            <br>
        </form>
        
        <h2>Results</h2>
        <?php if (!empty($customers)): ?>
            <table>
                <tr>   
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th></th>
                </tr>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo htmlspecialchars($customer['firstName']); ?></td>
                    <td><?php echo htmlspecialchars($customer['lastName']); ?></td>
                    <td><?php echo htmlspecialchars($customer['emailAddress']); ?></td>
                    <td>
                        <!-- Edit button -->
                        <form action="select_customers_form.php" method="post">
                            <input type="hidden" name="customerID" value="<?php echo $customer['customerID']; ?>" />
                            <input type="submit" value="Select">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No customers found<?php echo !empty($lastName) ? " with the last name '" . htmlspecialchars($lastName) . "'" : ''; ?>.</p>
        <?php endif; ?>
        <br/>
    </main>
</body>
</html>
