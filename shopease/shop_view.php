<!-- shop_view.php -->
<?php
// At the very top of your script
session_start(); // Start the session first

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once('database.php');

// Your logic here...

// Get product ID from query string and validate
$productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);
if (!$productID) {
    $_SESSION['feedback'] = 'Invalid product ID.';
    header('Location: shop.php');
    exit();
}

// Fetch product data from database
$queryProduct = 'SELECT p.*, c.categoryName 
                 FROM products p
                 JOIN categories c ON p.categoryID = c.categoryID
                 WHERE p.productID = :productID';
$statement = $db->prepare($queryProduct);
$statement->bindValue(':productID', $productID, PDO::PARAM_INT);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Check if product exists
if (!$product) {
    $_SESSION['feedback'] = 'Product not found.';
    header('Location: shop.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product View</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/shop.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <!-- Product Detail Section -->
    <main>

    <section>
    <?php
    // Check if we are in the admin directory
    $path = (strpos(__DIR__, 'admin') !== false) ? '../../view/product_view.php' : 'view/product_view.php';
    include($path);
    ?>
    </section>
</main>


    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
