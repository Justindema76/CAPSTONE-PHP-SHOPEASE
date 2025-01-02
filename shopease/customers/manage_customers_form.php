<!-- manage_customers_form.php -->

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../database.php');

// Initial query to fetch all customers with their country
$queryCustomers = 'SELECT c.*, co.countryName FROM customers c
                   LEFT JOIN countries co ON c.countryCode = co.countryCode';
$statement1 = $db->prepare($queryCustomers);
$statement1->execute();
$customers = $statement1->fetchAll();  
$statement1->closeCursor();

// Check if a last name was submitted
if (isset($_POST['last_name'])) {
    $lastName = $_POST['last_name'];

    // Query to search customers by last name, including country
    $queryCustomers = 'SELECT c.*, co.countryName FROM customers c
                       LEFT JOIN countries co ON c.countryCode = co.countryCode 
                       WHERE c.lastName LIKE :lastName';
    $statement1 = $db->prepare($queryCustomers);
    
    $statement1->bindValue(':lastName', '%' . $lastName . '%');
    $statement1->execute();
    
    // Get the customers that match the search criteria
    $customers = $statement1->fetchAll();  
    $statement1->closeCursor();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css"/>       
</head>
<body>
<?php include("../view/admin_sidebar.php"); ?>
    <main class="container mt-4">
        <h2 class="mb-4">Customer Search</h2>
        <form action="manage_customers_form.php" method="post" class="mb-5">
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input type="text" name="last_name" id="last_name" class="form-control" />
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
        
        <h2>Results</h2>
        <?php if (!empty($customers)): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>   
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email Address</th>
                        <th>Country</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($customer['firstName'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['lastName'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['emailAddress'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['countryName'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['city'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['state'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($customer['address'] ?? ''); ?></td>
                        <td>
                            <form action="select_customers_form.php" method="post">
                                <input type="hidden" name="customerID" value="<?php echo $customer['customerID']; ?>" />
                                <button type="submit" class="btn btn-secondary btn-sm">Select</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-danger">No customers found with the last name '<?php echo htmlspecialchars($lastName); ?>'.</p>
        <?php endif; ?>
    </main>
    <footer class="text-center mt-5">
        <p>&copy; 2024 ShopEase</p>
    </footer>
    <!-- Bootstrap JS (Optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
