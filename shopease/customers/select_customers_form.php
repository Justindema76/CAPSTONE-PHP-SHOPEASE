<!-- select_customers_form.php -->

<?php

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require('../database.php');

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
    
    // Fetch countries from the database
    $countriesQuery = 'SELECT countryCode, countryName FROM countries ORDER BY countryName';
    $countriesStatement = $db->prepare($countriesQuery);
    $countriesStatement->execute();
    $countries = $countriesStatement->fetchAll(PDO::FETCH_ASSOC);
    $countriesStatement->closeCursor();
} else {
    echo 'Invalid customer ID.';
    exit();
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
        <h2 class="mb-4">View/Update Customer</h2>
        
    <section>
               
        <!-- view/update_customer.php -->
        <form action="update_customer.php" method="post" id="add_product_form">
            <!-- Hidden field for customerID -->
            <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>" />

              <!-- Table for customer details -->
              <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">First Name:</th>
                        <td>
                            <input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($customer['firstName']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Last Name:</th>
                        <td>
                            <input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($customer['lastName']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Email:</th>
                        <td>
                            <input type="email" class="form-control" name="emailAddress" value="<?php echo htmlspecialchars($customer['emailAddress']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">City:</th>
                        <td>
                            <input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Address:</th>
                        <td>
                            <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">State:</th>
                        <td>
                            <input type="text" class="form-control" name="state" value="<?php echo htmlspecialchars($customer['state']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Postal Code:</th>
                        <td>
                            <input type="text" class="form-control" name="postalCode" value="<?php echo htmlspecialchars($customer['postalCode']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Country:</th>
                        <td>
                            <select name="countryCode" id="countryCode" class="form-select">
                                <?php foreach ($countries as $country): ?>
                                    <option value="<?php echo htmlspecialchars($country['countryCode']); ?>"
                                        <?php echo ($country['countryCode'] === $customer['countryCode']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($country['countryName']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Phone:</th>
                        <td>
                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Password:</th>
                        <td>
                            <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($customer['password']); ?>" />
                        </td>
                    </tr>
                </tbody>
            </table>
              <!-- Update customer button -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">Update Customer</button>
            </div>
        </form>

    </section>
 
          

        <p class="mt-3"><a href="manage_customers_form.php" class="btn btn-secondary">Search Customers</a></p>
    </main>
</body>
</html>
