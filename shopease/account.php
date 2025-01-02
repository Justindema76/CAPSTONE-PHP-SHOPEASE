<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require('database.php');
session_start();

// Check if customer is logged in
if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];
} else {
    echo 'Customer is not logged in.';
    exit();
}

// Fetch customer details
$query = 'SELECT * FROM customers WHERE customerID = :customerID';
$statement = $db->prepare($query);
$statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
$statement->execute();
$customer = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Check if customer exists
if (!$customer) {
    echo 'Customer not found.';
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the customer data from the form
    $customerID = $_POST['customerID'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $emailAddress = $_POST['emailAddress'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $postalCode = $_POST['postalCode'];
    $countryCode = $_POST['countryCode'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

   

    // Prepare the SQL update query
    $query = 'UPDATE customers SET firstName = :firstName, lastName = :lastName, emailAddress = :emailAddress,
              city = :city, address = :address, state = :state, postalCode = :postalCode, countryCode = :countryCode,
              phone = :phone, password = :password WHERE customerID = :customerID';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $firstName, PDO::PARAM_STR);
    $statement->bindValue(':lastName', $lastName, PDO::PARAM_STR);
    $statement->bindValue(':emailAddress', $emailAddress, PDO::PARAM_STR);
    $statement->bindValue(':city', $city, PDO::PARAM_STR);
    $statement->bindValue(':address', $address, PDO::PARAM_STR);
    $statement->bindValue(':state', $state, PDO::PARAM_STR);
    $statement->bindValue(':postalCode', $postalCode, PDO::PARAM_STR);
    $statement->bindValue(':countryCode', $countryCode, PDO::PARAM_STR);
    $statement->bindValue(':phone', $phone, PDO::PARAM_STR);
    $statement->bindValue(':password', $password, PDO::PARAM_STR);
    $statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
    $statement->execute();
    $statement->closeCursor();

    // Redirect to checkout page or show a success message
    header('Location: checkout.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop.css">
  
</head>
<body>
    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <!-- Account Info Form -->
    <form action="account.php" method="post">
        <!-- Hidden field for customerID -->
        <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>" />

        <!-- Account Info Section -->
        <section class="my-2 py-2">
            <div class="row container mx-auto">
                <div class="text-center mt-5 pt-5">
                    <h3 class="font-weight-bold">Account Info</h3>
                    <hr class="mx-auto">
                    <div class="account-info">
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
                                        <select name="countryCode" class="form-select">
                                            <!-- Add country options here -->
                                            <option value="US" <?php echo ($customer['countryCode'] === 'US') ? 'selected' : ''; ?>>United States</option>
                                            <option value="CA" <?php echo ($customer['countryCode'] === 'CA') ? 'selected' : ''; ?>>Canada</option>
                                            <!-- Add more countries as needed -->
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
                                        <input type="password" class="form-control" name="text" value="<?php echo htmlspecialchars($customer['password']); ?>" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Update customer button -->
                        <div class="text-end">
                            <button type="submit">Update Customer</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
