<?php
// Start session
session_start();

// Include database connection
require('database.php');

// Error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if customer is logged in
if (!isset($_SESSION['customerID'])) {
    header('Location: login.php');
    exit();
}

$customerID = $_SESSION['customerID'];

try {
    // Fetch customer details with country name
    $queryCustomer = '
        SELECT customers.*, countries.countryName 
        FROM customers
        JOIN countries ON customers.countryCode = countries.countryCode
        WHERE customers.customerID = :customerID';
    $statement = $db->prepare($queryCustomer);
    $statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if (!$customer) {
        echo 'No customer found with the provided ID.';
        exit();
    }

    // Fetch cart items
    $queryCart = '
        SELECT 
            c.cartID,
            c.productID,
            c.quantity,
            p.productName,
            p.imageName,
            p.listPrice,
            (p.listPrice * c.quantity) AS total 
        FROM cart c
        JOIN products p ON c.productID = p.productID
        WHERE c.customerID = :customerID';
    $statement = $db->prepare($queryCart);
    $statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
    $statement->execute();
    $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

    if (!$cartItems) {
        echo 'Your cart is empty.';
        exit();
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
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

    <!-- Hidden field for customerID -->
    <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>">

    <!-- CHECKOUT SECTION -->
    <section class="my-5 py-5">
        <div class="container">
            <h1 class="font-weight-bold text-center" style="border-bottom: 2px solid #d00;">Checkout</h1>
            <br>
            <div class="row">
                <!-- Shipping Information -->
                <div class="col-md-6">
                    <h3>Shipping Address</h3>
                    <hr class="mx-auto">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($customer['firstName'] . ' ' . $customer['lastName']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($customer['emailAddress']); ?></p>
                    <p><strong>Address:</strong> 
                        <?php echo htmlspecialchars(
                            $customer['address'] . ', ' . 
                            $customer['city'] . ', ' . 
                            $customer['state'] . ', ' . 
                            $customer['postalCode'] . ', ' . 
                            $customer['countryName']
                        ); ?>
                    </p>
                    <form action="account.php" method="get">
                        <button type="submit" >My Account</button>
                    </form>
                </div>

                <!-- Order Summary -->
                <div class="col-md-6">
                    <h3>Your Order</h3>
                    <hr class="mx-auto">
                    <table class="table table-bordered cart-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                <td>
                                  
                                        <img src="images/<?php echo htmlspecialchars($item['imageName']); ?>" alt="<?php echo htmlspecialchars($item['productName']); ?>" style="width: 90px; height: auto; margin-right: 10px;">
                                        
                                   
                                </td>
                                    <td>
                                            <p><?php echo htmlspecialchars($item['productName']); ?></p>
                                        </td>
                                    <td>$<?php echo number_format($item['listPrice'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td>$<?php echo number_format($item['total'], 2); ?></td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="text-end py-3">
                        <h3>Total: $<?php echo number_format(array_sum(array_map(fn($item) => $item['listPrice'] * $item['quantity'], $cartItems)), 2); ?></h3>
                    </div>
                </div>
            </div>

            <!-- Checkout Button -->
            <div class="text-center mt-4">
                <form action="process-checkout.php" method="POST">
                    <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>">
                    <button type="submit" class="w-50">Place Order</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
