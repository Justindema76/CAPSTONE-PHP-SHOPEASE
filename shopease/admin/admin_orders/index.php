<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once('../../database.php');



// Fetch all orders
try {
  $query = '
  SELECT o.orderID, o.orderDate, o.totalAmount, o.orderStatus, oi.productID, oi.quantity, oi.price, 
         p.productName, p.stock, c.customerID, c.firstName, c.lastName, c.emailAddress, c.phone, c.address, c.city, c.state, c.postalCode
  FROM orders o
  JOIN order_items oi ON o.orderID = oi.orderID
  JOIN products p ON oi.productID = p.productID
  JOIN customers c ON o.customerID = c.customerID
  ORDER BY o.orderDate DESC';

    $statement = $db->prepare($query);
    $statement->execute();
    $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shipOrder'])) {
  $orderID = $_POST['orderID']; // The specific order ID
  $productID = $_POST['productID']; // The specific product ID

  try {
      // Start a transaction
      $db->beginTransaction();

      // Update the stock for the product
      $queryUpdateStock = '
          UPDATE products
          SET stock = stock - (
              SELECT quantity FROM order_items WHERE orderID = :orderID AND productID = :productID
          )
          WHERE productID = :productID';
      $stmt = $db->prepare($queryUpdateStock);
      $stmt->bindValue(':orderID', $orderID, PDO::PARAM_INT);
      $stmt->bindValue(':productID', $productID, PDO::PARAM_INT);
      $stmt->execute();

      // Update the order status to "shipped"
      $queryUpdateStatus = '
          UPDATE orders
          SET orderStatus = "shipped"
          WHERE orderID = :orderID';
      $stmt = $db->prepare($queryUpdateStatus);
      $stmt->bindValue(':orderID', $orderID, PDO::PARAM_INT);
      $stmt->execute();

      // Commit the transaction
      $db->commit();

      echo '<div class="alert alert-success">Order successfully marked as shipped!</div>';
  } catch (Exception $e) {
      $db->rollBack(); // Roll back the transaction in case of an error
      echo '<div class="alert alert-danger">Error updating order: ' . htmlspecialchars($e->getMessage()) . '</div>';
  }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../../view/admin_sidebar.php"); ?>
    <div class="container my-5">
        <h1>Manage Orders</h1>
        <form method="POST">
        <table class="table table-striped">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Ship</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo htmlspecialchars($order['orderID']); ?></td>
                <td><?php echo htmlspecialchars($order['customerID']); ?></td>
                <td><?php echo htmlspecialchars($order['firstName'] . ' ' . $order['lastName']); ?></td>
                <td><?php echo htmlspecialchars($order['productName']); ?></td>
                <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                <td><?php echo htmlspecialchars($order['orderDate']); ?></td>
                <td>$<?php echo htmlspecialchars(number_format($order['totalAmount'], 2)); ?></td>
                <td><?php echo htmlspecialchars($order['orderStatus']); ?></td>
                <td>
    <?php if ($order['orderStatus'] === 'pending'): ?>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($order['orderID']); ?>">
            <input type="hidden" name="productID" value="<?php echo htmlspecialchars($order['productID']); ?>">
            <button type="submit" name="shipOrder" class="btn btn-success">Ship</button>
        </form>
    <?php else: ?>
        <button class="btn btn-danger" >Ship</button>
    <?php endif; ?>
</td>

            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


            <button type="submit" class="btn btn-primary">Update Orders</button>
        </form>
    </div>
</body>
</html>
