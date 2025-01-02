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
if (isset($_SESSION['customerID'])) {
    $customerID = $_SESSION['customerID'];
} else {
    echo 'Customer is not logged in.';
    exit();
}

// Fetch customer data
$queryCustomer = 'SELECT * FROM customers WHERE customerID = :customerID';
$statement = $db->prepare($queryCustomer);
$statement->bindValue(':customerID', $customerID);
$statement->execute();
$customer = $statement->fetch();
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
    WHERE c.customerID = :customerID
';
$statement = $db->prepare($queryCart);
$statement->bindValue(':customerID', $customerID, PDO::PARAM_INT);
$statement->execute();
$cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Add item to cart
function add_item($productID, $quantity) {
    global $db, $customerID;

    if ($quantity > 0) {
        $stmt = $db->prepare("SELECT * FROM cart WHERE productID = :productID AND customerID = :customerID");
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $stmt = $db->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE productID = :productID AND customerID = :customerID");
        } else {
            $stmt = $db->prepare("INSERT INTO cart (productID, customerID, quantity) VALUES (:productID, :customerID, :quantity)");
        }

        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }
}

// Update cart item
function update_item($productID, $quantity) {
    global $db, $customerID;

    if ($quantity > 0) {
        $stmt = $db->prepare("UPDATE cart SET quantity = :quantity WHERE productID = :productID AND customerID = :customerID");
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        remove_item($productID);
    }
}

// Remove cart item
function remove_item($productID) {
    global $db, $customerID;

    $stmt = $db->prepare("DELETE FROM cart WHERE productID = :productID AND customerID = :customerID");
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $stmt->execute();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add' && isset($_POST['productID'], $_POST['quantity'])) {
        add_item($_POST['productID'], $_POST['quantity']);
    } elseif ($action === 'update' && isset($_POST['productID'], $_POST['quantity'])) {
        update_item($_POST['productID'], $_POST['quantity']);
    } elseif ($action === 'remove' && isset($_POST['productID'])) {
        remove_item($_POST['productID']);
    }

    header("Location: customer-cart.php");
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
    <style>
        /* Target only this specific table using its class */
      
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <!-- Hidden field for customerID -->
    <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>" />

    
    
    <section class="cart container my-5 py-5">
    <div class="container mt-2">
        <h2>Your Shopping Cart</h2>
        <hr>
    </div>

    <?php if (!empty($cartItems)): ?>
        <table class="table table-striped cart-table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="images/<?php echo htmlspecialchars($item['imageName']); ?>" alt="<?php echo htmlspecialchars($item['productName']); ?>" style="width: 90px; height: auto; margin-right: 10px;">
                        <div>
                            <p><?php echo htmlspecialchars($item['productName']); ?></p>
                        </div>
                    </div>
                </td>

                <!-- update quantity -->
                <td><form action="customer-cart.php" method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="productID" value="<?= $item['productID'] ?>">
                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1"class="edit-btn">
                        <button type="submit" class="ms-2">Update</button>
                    </form></td>
                    <td>$<?= number_format($item['listPrice'], 2) ?></td>
                    <td>$<?= number_format($item['total'], 2) ?></td>
                <td>
                    <!-- remove product -->
                <form method="POST" action="customer-cart.php">
                    <input type="hidden" name="action" value="remove">
                    <input type="hidden" name="productID" value="<?= $item['productID'] ?>">
                    <button type="submit">Remove</button>
                </form>

                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>



        <!-- Cart Total -->
         
        <div class="text-end py-3 cart-total">
        <h3>Total: $<?php echo number_format(array_sum(array_map(fn($item) => $item['listPrice'] * $item['quantity'], $cartItems)), 2); ?></h3>
        </div>

        <div class="d-flex justify-content-center gap-3 py-2">
            <!-- CONTINUE SHOPPING -->
            <button onclick="window.location.href='shop.php'">Continue Shopping</button>
            <!-- CHECKOUT -->
            <button onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
        </div>
    <?php else: ?>
        <p class="alert alert-info">Your cart is empty.</p>
        <a href="shop.php" class="btn btn-danger">Continue Shopping</a>
    <?php endif; ?>
</section>



    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
