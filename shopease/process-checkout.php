<?php
// Start session
session_start();

// Include database connection
require('database.php');

// Error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize the checkout success flag
$checkoutSuccess = false;

// Check if customer is logged in and form submitted
if (!isset($_POST['customerID']) || !isset($_SESSION['customerID'])) {
    $checkoutSuccess = false;
} else {
    $customerID = $_POST['customerID'];

    try {
        // Start transaction
        $db->beginTransaction();

        // Fetch cart items
        $queryCart = '
            SELECT 
                c.cartID,
                c.productID,
                c.quantity,
                p.listPrice
            FROM cart c
            JOIN products p ON c.productID = p.productID
            WHERE c.customerID = :customerID';
        $statement = $db->prepare($queryCart);
        $statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
        $statement->execute();
        $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$cartItems) {
            throw new Exception('Cart is empty. Cannot proceed with checkout.');
        }

        // Calculate total amount
        $totalAmount = array_sum(array_map(fn($item) => $item['listPrice'] * $item['quantity'], $cartItems));

        // Insert into orders table
        $insertOrderQuery = 'INSERT INTO orders (customerID, totalAmount) VALUES (:customerID, :totalAmount)';
        $insertOrderStmt = $db->prepare($insertOrderQuery);
        $insertOrderStmt->bindValue(':customerID', $customerID, PDO::PARAM_INT);
        $insertOrderStmt->bindValue(':totalAmount', $totalAmount, PDO::PARAM_STR);
        $insertOrderStmt->execute();

        // Get the last inserted orderID
        $orderID = $db->lastInsertId();

        // Insert items into order_items table
        foreach ($cartItems as $item) {
            $insertOrderItemQuery = '
                INSERT INTO order_items (orderID, productID, quantity, price) 
                VALUES (:orderID, :productID, :quantity, :price)';
            $insertOrderItemStmt = $db->prepare($insertOrderItemQuery);
            $insertOrderItemStmt->bindValue(':orderID', $orderID, PDO::PARAM_INT);
            $insertOrderItemStmt->bindValue(':productID', $item['productID'], PDO::PARAM_INT);
            $insertOrderItemStmt->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);
            $insertOrderItemStmt->bindValue(':price', $item['listPrice'], PDO::PARAM_STR);
            $insertOrderItemStmt->execute();

            // Update product stock in products table
            $updateStockQuery = 'UPDATE products SET stock = stock - :quantity WHERE productID = :productID';
            $updateStockStmt = $db->prepare($updateStockQuery);
            $updateStockStmt->bindValue(':quantity', $item['quantity'], PDO::PARAM_INT);
            $updateStockStmt->bindValue(':productID', $item['productID'], PDO::PARAM_INT);
            $updateStockStmt->execute();
        }

        // Clear the cart
        $deleteCartQuery = 'DELETE FROM cart WHERE customerID = :customerID';
        $deleteCartStmt = $db->prepare($deleteCartQuery);
        $deleteCartStmt->bindValue(':customerID', $customerID, PDO::PARAM_INT);
        $deleteCartStmt->execute();

        // Commit transaction
        $db->commit();

        // Set success flag
        $checkoutSuccess = true;

    } catch (PDOException $e) {
        // Rollback transaction if an error occurs
        $db->rollBack();
        $checkoutSuccess = false;
        $errorMessage = 'Database Error: ' . $e->getMessage();
    } catch (Exception $e) {
        // Handle other exceptions
        $checkoutSuccess = false;
        $errorMessage = 'Error: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop.css">
</head>
<body>
    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <!-- Confirmation Message -->
    <?php if ($checkoutSuccess): ?>
        <br>
        <section class="my-5 py-5">
            <div class="container text-center">
                <h1>Order Placed Successfully!</h1>
                <p>Thank you for your order. Your purchase has been successfully processed.</p>
            </div>
        </section>
    <?php else: ?>
        <section class="my-5 py-5">
            <div class="container text-center">
                <h1>Something went wrong!</h1>
                <p>There was an issue with your order. Please try again later or contact support.</p>
                <?php if (isset($errorMessage)): ?>
                    <p class="text-danger"><?php echo htmlspecialchars($errorMessage); ?></p>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
