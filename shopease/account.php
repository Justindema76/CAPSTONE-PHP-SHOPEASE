<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require('database.php');
session_start();

// Check if customer is logged in
if (!isset($_SESSION['customerID'])) {
    echo 'Customer is not logged in.';
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

    // Query to fetch orders for the logged-in customer with order items
    $query = '
        SELECT o.orderID, o.orderDate, o.totalAmount, o.orderStatus, oi.productID, oi.quantity, oi.price, p.productName 
        FROM orders o
        JOIN order_items oi ON o.orderID = oi.orderID
        JOIN products p ON oi.productID = p.productID
        WHERE o.customerID = :customerID
        ORDER BY o.orderDate DESC';
    $statement = $db->prepare($query);
    $statement->bindValue(':customerID', $customerID);
    $statement->execute();
    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
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

    <!-- ACCOUNT SECTION -->
    <section class="my-5 py-5">
        <div class="container">
            <h1 class="font-weight-bold text-center" style="border-bottom: 2px solid #d00;">Account Details</h1>
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
                    <form action="account-details.php" method="get">
                        <button type="submit">Update</button>
                    </form>
                </div>

                <!-- Orders Section -->
                <div class="col-md-6">
                    <h3>Your Orders</h3>
                    <hr class="mx-auto">
                    <?php if (count($orders) > 0): ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Order Date</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order['orderID']); ?></td>
                                        <td><?php echo htmlspecialchars($order['productName']); ?></td>
                                        <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                        <td>$<?php echo htmlspecialchars(number_format($order['price'], 2)); ?></td>
                                        <td><?php echo htmlspecialchars($order['orderDate']); ?></td>
                                        <td>$<?php echo htmlspecialchars(number_format($order['totalAmount'], 2)); ?></td>
                                        <td style="color: <?php echo ($order['orderStatus'] === 'Pending') ? 'red' : 'inherit'; ?>;">
                                            <?php echo htmlspecialchars($order['orderStatus']); ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>You have no orders yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
