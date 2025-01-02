<!-- view/customer.php -->
<!-- customers/add_customer.php -->

<?php
// Display errors for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Include database connection
require('database.php');

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
    header("Location: home.php");
    exit();
} else {
    echo "Error: All required fields must be filled out.";
}
?>

<section class="container my-5" style="margin-top: 50px;">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Registation Form</h2>
          
        </div>
    <form id="register-form"  method="post" class="row needs-validation g-3" novalidate>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" name="firstName" id="firstName" class="form-control" required>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" name="lastName" id="lastName" class="form-control" required>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="emailAddress" class="form-label">Email Address</label>
            <input type="email" name="emailAddress" id="emailAddress" class="form-control" required>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" id="address" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="city" class="form-label">City</label>
            <input type="text" name="city" id="city" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="state" class="form-label">State</label>
            <input type="text" name="state" id="state" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="postalCode" class="form-label">Postal Code</label>
            <input type="text" name="postalCode" id="postalCode" class="form-control">
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="countryCode" class="form-label">Country</label>
            <select name="countryCode" id="countryCode" class="form-select">
                <?php foreach ($countries as $country): ?>
                    <option value="<?php echo htmlspecialchars($country['countryCode']); ?>">
                        <?php echo htmlspecialchars($country['countryName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-danger ">Register</button>
        </div>
    </form>
</section>
