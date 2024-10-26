<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
require("../../database.php");

// Fetch categories from the database
$queryCategories = 'SELECT * FROM categories';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch categories as an associative array
$statement->closeCursor();

// Get product ID from POST
$product_id = filter_input(INPUT_POST, 'productID', FILTER_VALIDATE_INT);

if ($product_id) {
    // Fetch product details for editing
    $query = 'SELECT * FROM products WHERE productID = :product_id';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id, PDO::PARAM_INT);
    $statement->execute();
    $product = $statement->fetch(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    
    // Check if product was found
    if (!$product) {
        echo 'No product found with this ID.';
        exit();
    }
} else {
    echo 'Invalid product ID.';
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
    <?php include("../../view/admin_sidebar.php"); ?>
    <main>
    <h1>Product Manager - Edit Product Form</h1>
    <section>
        
        <form action="edit_product.php" method="post" id="edit_product_form">
            <div id="data">
                
                <label for="category">Category:</label>
                <select name="categoryID" id="category" required>
                    <!-- Display the current category as the first option -->
                    <option value="<?php echo htmlspecialchars($product['categoryID'] ?? ''); ?>">
                        <?php 
                        // Find the category name for the selected categoryID
                        foreach ($categories as $category) {
                            if ($category['categoryID'] == ($product['categoryID'] ?? '')) {
                                echo htmlspecialchars($category['categoryName']);
                            }
                        }
                        ?>
                    </option>
                    <!-- Add the other categories as options -->
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo htmlspecialchars($category['categoryID']); ?>">
                            <?php echo htmlspecialchars($category['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Product Code:</label>
                <input type="text" name="productCode" value="<?php echo htmlspecialchars($product['productCode'] ?? ''); ?>" required><br>

                <label>Product Name:</label>
                <input type="text" name="productName" value="<?php echo htmlspecialchars($product['productName'] ?? ''); ?>" required><br>
                
                <label>Description:</label>
                <textarea name="description" rows="5" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea><br>

                <label>Price:</label>
                <input type="text" name="listPrice" value="<?php echo htmlspecialchars(number_format($product['listPrice'] ?? 0, 2)); ?>" required><br>

                <label>Discount Percent:</label>
                <input type="text" name="discountPercent" value="<?php echo htmlspecialchars($product['discountPercent'] ?? ''); ?>" required><br>

                <label>Stock:</label>
                <input type="text" name="stock" value="<?php echo htmlspecialchars($product['stock'] ?? ''); ?>" required><br>

                <!-- Hidden field for the product ID -->
                <input type="hidden" name="productID" value="<?php echo htmlspecialchars($product['productID']); ?>">
                <input type="submit" value="Submit">
            </div>
        </form>
        
        <div id="formatting_directions">
            <h2>How to format the Description entry</h2>
            <ul>
                <li>Use two returns to start a new paragraph.</li>
                <li>Use an asterisk to mark items in a bulleted list.</li>
                <li>Use one return between items in a bulleted list.</li>
                <li>Use standard HTML tags for bold and italics.</li>
            </ul>
        </div>
    </section>
    </main>
</body>
</html>
