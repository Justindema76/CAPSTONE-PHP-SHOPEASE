<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}



// Include database connection
require_once('database.php');

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}




// Fetch the product details from the database
function get_product($productID) {
    global $db;

    $stmt = $db->prepare("SELECT productName, listPrice, imageName FROM products WHERE productID = :productID");
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


// Add item to cart
function add_item($productID, $quantity) {
    global $db;

    if ($quantity > 0) {
        $product = get_product($productID);
        if ($product) {
            $productName = $product['productName'];
            $productPrice = $product['listPrice'];
            $imageName = $product['imageName']; // Add this line
            $total = $quantity * $productPrice;

            // Add to session
            $_SESSION['cart'][$productID] = [
                'name' => $productName,
                'cost' => $productPrice,
                'qty' => $quantity,
                'total' => $total,
                'image' => $imageName, // Add this line
            ];

            // Add to DB
            add_item_to_db($productID, $quantity);
        }
    }
}


// Update item quantity in cart
function update_item($productID, $quantity) {
    if (isset($_SESSION['cart'][$productID]) && $quantity > 0) {
        // Update the session cart
        $_SESSION['cart'][$productID]['qty'] = $quantity;
        $_SESSION['cart'][$productID]['total'] = $quantity * $_SESSION['cart'][$productID]['cost'];

        // Update the DB for this product (no userID)
        update_item_in_db($productID, $quantity);
    } else {
        echo "Invalid quantity or product not found in cart.<br>";
    }
}

// Remove item from cart
function remove_item($productID) {
    // Check if the item is in the session cart
    if (isset($_SESSION['cart'][$productID])) {
        // Unset the item from the session cart
        unset($_SESSION['cart'][$productID]);

        // Now remove the item from the database (no userID)
        remove_item_from_db($productID);
    }
}

// Remove item from DB
function remove_item_from_db($productID) {
    global $db;
    $stmt = $db->prepare("DELETE FROM cart WHERE productID = :productID");
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->execute();
}

// Update item in DB (no userID required)
function update_item_in_db($productID, $quantity) {
    global $db;
    $stmt = $db->prepare("UPDATE cart SET quantity = :quantity WHERE productID = :productID");
    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->execute();
}

// Handle the POST request to remove the item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $productID = $_POST['key'];
    remove_item($productID);
}

// Handle form submission for adding, updating, or removing items
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $productID = $_POST['productID'];
        $quantity = $_POST['quantity'];
        add_item($productID, $quantity);
    } elseif ($action === 'update') {
        $productID = $_POST['key'];
        $quantity = $_POST['quantity'];
        update_item($productID, $quantity);
    } elseif ($action === 'remove') {
        $productID = $_POST['key'];
        remove_item($productID);
    }
}

// Calculate cart subtotal
function get_subtotal() {
    $subtotal = 0;
    foreach ($_SESSION['cart'] as $item) {
        $subtotal += $item['total'];
    }
    return number_format($subtotal, 2);
}

function add_item_to_db($productID, $quantity) {
    global $db;

    // Get the product details
    $product = get_product($productID);
    $productName = $product['productName'];

    // Check if the customer is logged in
    $customerID = isset($_SESSION['customerID']) ? $_SESSION['customerID'] : null;

    // Check if the item is already in the cart for the customer
    $stmt = $db->prepare("SELECT * FROM cart WHERE productID = :productID AND (customerID = :customerID OR customerID IS NULL)");
    $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
    $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // If the item already exists, update the quantity
        $stmt = $db->prepare("UPDATE cart SET quantity = quantity + :quantity WHERE productID = :productID AND (customerID = :customerID OR customerID IS NULL)");
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        // If the item is not in the cart, insert it
        $stmt = $db->prepare("INSERT INTO cart (productID, productName, quantity, customerID) VALUES (:productID, :productName, :quantity, :customerID)");
        $stmt->bindParam(':productID', $productID, PDO::PARAM_INT);
        $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
        $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindParam(':customerID', $customerID, PDO::PARAM_INT);
        $stmt->execute();
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Target only this specific table using its class */
        .cart-table {
            width: 100%; /* Adjusts the table width to fill the container */
            table-layout: fixed; /* Ensures equal width distribution for table cells */
        }

        /* Ensures that all td elements are inline */
        .cart-table td {
            vertical-align: middle; /* Centers content vertically within the cell */
            padding: 10px; /* Adds padding to each cell */
            text-align: left; /* Aligns text to the left (can be changed to center or right if needed) */
        }

        /* Styling for the product-info div to keep things inline */
        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            width: 80px; /* Set image width */
            height: auto;
            margin-right: 10px; /* Adds space between the image and text */
        }

        .product-info p {
            margin: 0; /* Removes the margin for the paragraph, making the layout tighter */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <section class="cart container my-5 py-5">
        <div class="container mt-2">
            <h2>Your Shopping Cart</h2>
            <hr>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="table table-striped cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach ($_SESSION['cart'] as $key => $item): ?>
    <tr>
        <td>
            <div class="product-info">
                <img src="images/<?php echo htmlspecialchars($item['image'] ?? 'default.jpg'); ?>" alt="<?php echo htmlspecialchars($item['name'] ?? 'Unnamed Product'); ?>" style="width: 80px; height: auto; margin-right: 10px;">
                <div>
                    <p><?php echo htmlspecialchars($item['name'] ?? 'Unnamed Product'); ?></p>
                </div>
            </div>
        </td> 
        <td>
            <!-- update cart -->
            <form action="cart.php" method="post">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="key" value="<?php echo htmlspecialchars($key); ?>">
                <input type="number" name="quantity" value="<?php echo htmlspecialchars($item['qty'] ?? 1); ?>" min="1" class="edit-btn">
                <button type="submit" class="ms-2">Update</button>
            </form>
        </td>
        <td>$<?php echo number_format($item['cost'] ?? 0, 2); ?></td>
        <td>$<?php echo number_format($item['total'], 2); ?></td>
        <td>
            <form action="cart.php" method="post">
                <input type="hidden" name="action" value="remove">
                <input type="hidden" name="key" value="<?php echo htmlspecialchars($key); ?>">
                <button type="submit">Remove</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
</table>

            <!-- Cart Total -->
            <div class="text-end py-3">
                <h3>Total: $<?php echo get_subtotal(); ?></h3>
                
            </div>

            <div class="d-flex justify-content-center gap-3 py-2">
                <!-- CONTINUE SHOPPING -->
                <button onclick="window.location.href='shop.php'">Continue Shopping</button>
                
                <!-- CHECKOUT -->
                <button>Proceed to Checkout</button>
            </div>

        <?php else: ?>
            <p class="alert alert-info">Your cart is empty.</p>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>