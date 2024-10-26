<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once('../../database.php');
require_once('../../util/tags.php');

// Check if the database connection exists
if (!$db) {
    die("Database connection failed.");
}

// Fetch categories for the dropdown
$queryCategories = 'SELECT * FROM categories';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();

// Check if a category ID is selected
$categoryID = filter_input(INPUT_GET, 'categoryID', FILTER_VALIDATE_INT);

// Base query to fetch products
$queryProduct = 'SELECT p.*, c.categoryName FROM products p 
                 JOIN categories c ON p.categoryID = c.categoryID';

// Add a WHERE clause if a category ID is specified
if ($categoryID && $categoryID != 0) {
    $queryProduct .= ' WHERE p.categoryID = :categoryID';
}

// Prepare and execute the statement
$statement = $db->prepare($queryProduct);

// Bind the category ID if provided
if ($categoryID && $categoryID != 0) {
    $statement->bindValue(':categoryID', $categoryID);
}

$statement->execute();

// Fetch product data
$productData = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="../../css/products.css">
</head>
<body>
<?php include("../../view/admin_sidebar.php"); ?>

<main>
    <h1>ShopEase - Manage Products</h1>
    <button class="form_button" onclick="window.location.href='../admin_products/add_product_form.php';">
        Add New Product
    </button>

    <!-- Category Selection -->
    <section>
        <h2>Select a Category</h2>
        <form action="" method="get">
            <select name="categoryID" id="category" required>
                <option value="">Select Category</option>
                <option value="0">All Products</option>
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>" 
                        <?php if ($categoryID == $category['categoryID']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($category['categoryName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button class="form_button" type="submit">Filter Categories</button>
        </form>
    </section>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th>Category</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <!-- <th>Description</th> -->
                <th>Price</th>
                <th>Discount Percent</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($productData) > 0) : ?>
                <?php foreach ($productData as $product) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['categoryName']); ?></td>
                        <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                        <td><?php echo htmlspecialchars($product['productName']); ?></td>
                        <!-- <td><?php echo htmlspecialchars($product['description']); ?></td> -->
                        <td><?php echo htmlspecialchars($product['listPrice']); ?></td>
                        <td><?php echo htmlspecialchars($product['discountPercent']); ?></td>
                        <td><?php echo htmlspecialchars($product['stock']); ?></td>
                        
                        <td>
    <!-- View Product Button -->
    <form action="../admin_products/product_view.php" method="get">
        <input type="hidden" name="productID" value="<?php echo  $product['productID']; ?>">
        <button type="submit" class="form_button">View</button>
    </form></td>
    <td>
    <!-- Delete Button -->
    <form action="../admin_products/delete_product.php" method="post">
        <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>" />
        <input type="hidden" name="categoryID" value="<?php echo $product['categoryID']; ?>" />
        <button type="submit" class="form_button">Delete</button>
    </form>
</td>

                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8">No products available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
