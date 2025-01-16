<?php
// Start the session
session_start();

// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require('database.php');

// Check if the user is logged in
if (!isset($_SESSION['customerID'])) {
    echo "You must be logged in to update your information.";
    exit();
}

// Get the logged-in customer's ID from the session
$customerID = $_SESSION['customerID'];

// Initialize variables
$customer = null;
$countries = [];
$errorMessage = null;

// Fetch the customer's current data
$queryCustomer = 'SELECT * FROM customers WHERE customerID = :customerID';
$statement = $db->prepare($queryCustomer);
$statement->bindValue(':customerID', $customerID);
$statement->execute();
$customer = $statement->fetch();
$statement->closeCursor();

// Check if the customer exists
if (!$customer) {
    echo "Error: Customer not found.";
    exit();
}

// Fetch the list of countries
$countriesQuery = 'SELECT countryCode, countryName FROM countries ORDER BY countryName';
$countriesStatement = $db->prepare($countriesQuery);
$countriesStatement->execute();
$countries = $countriesStatement->fetchAll(PDO::FETCH_ASSOC);
$countriesStatement->closeCursor();

// Handle the form submission for updating customer details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
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

    // Validate and update the customer's information
    if ($firstName && $lastName && $emailAddress) {
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

        echo "Your information has been successfully updated.";
        header("Location: checkout.php");
        exit();
    } else {
        $errorMessage = "Error: Please fill out all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop.css">
</head>
<body>
    <!-- Navbar -->
<?php include("view/navbar.php"); ?>
<br>
<main class="container mt-5">
<h2 class="mb-4">Update Your Information</h2>

<?php if ($errorMessage): ?>
<div class="alert alert-danger"><?php echo htmlspecialchars($errorMessage); ?></div>
<?php endif; ?>

<form action="" method="post">
<table class="table table-bordered">
<tbody>
    <tr>
        <th scope="row">First Name:</th>
        <td><input type="text" class="form-control" name="firstName" value="<?php echo htmlspecialchars($customer['firstName']); ?>" required></td>
    </tr>
    <tr>
        <th scope="row">Last Name:</th>
        <td><input type="text" class="form-control" name="lastName" value="<?php echo htmlspecialchars($customer['lastName']); ?>" required></td>
    </tr>
    <tr>
        <th scope="row">Email:</th>
        <td><input type="email" class="form-control" name="emailAddress" value="<?php echo htmlspecialchars($customer['emailAddress']); ?>" required></td>
    </tr>
    <tr>
        <th scope="row">City:</th>
        <td><input type="text" class="form-control" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>"></td>
    </tr>
    <tr>
        <th scope="row">Address:</th>
        <td><input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>"></td>
    </tr>
    <tr>
        <th scope="row">State:</th>
        <td><input type="text" class="form-control" name="state" value="<?php echo htmlspecialchars($customer['state']); ?>"></td>
    </tr>
    <tr>
        <th scope="row">Postal Code:</th>
        <td><input type="text" class="form-control" name="postalCode" value="<?php echo htmlspecialchars($customer['postalCode']); ?>"></td>
    </tr>
    <tr>
        <th scope="row">Country:</th>
        <td>
            <select name="countryCode" class="form-select">
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
        <td><input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($customer['phone']); ?>"></td>
    </tr>
    <tr>
    <th scope="row">Password:</th>
    <td>
        <div class="input-group">
            <input type="password" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($customer['password']); ?>">
            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('password')">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </td>
</tr>
<tr>
    <th scope="row">Confirm Password:</th>
    <td>
        <div class="input-group">
            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirmPassword')">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </td>
</tr>

                </tbody>
            </table>
            <div class="text-end">
                <button type="submit">Update Information</button>
            </div>
        </form>
    </main>
    <script>
function togglePasswordVisibility(fieldId) {
    const inputField = document.getElementById(fieldId);
    const icon = inputField.nextElementSibling.querySelector('i');

    if (inputField.type === "password") {
        inputField.type = "text";
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        inputField.type = "password";
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>
