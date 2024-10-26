<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require_once('../../database.php');



// Get product ID from query string and validate
$productID = filter_input(INPUT_GET, 'productID', FILTER_VALIDATE_INT);
if (!$productID) {
    $_SESSION['feedback'] = 'Invalid product ID.';
    header('Location: ../../admin/admin_products/index.php');
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
    header('Location: product_view.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
    <?php include("../../view/admin_sidebar.php"); ?>
    <main>
    <?php include("../../view/product_view.php"); ?>

                <div class="last_paragraph">
                    <form action="../admin_products/edit_product_form.php" method="post" id="edit_button_form">
                        <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                        <input type="hidden" name="categoryID" value="<?php echo $product['categoryID']; ?>"> 
                        <button type="submit" class="form_button">Edit Product</button>
                    </form>
                    <form action="../admin_products/delete_product.php" method="post">
                        <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>" />
                        <input type="hidden" name="categoryID" value="<?php echo $product['categoryID']; ?>" />
                        <button type="submit" class="form_button">Delete Product</button>
                    </form>

                </div>
            </div>
        </div>
    </main>
</body>
</html>
