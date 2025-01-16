<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once('../../database.php');


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
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/.css">
</head>
<body>
    <?php include("../../view/admin_sidebar.php"); ?>

    <main class="container mt-4">
        <h3 class="mb-4">Manage Products</h3>
        <button class="btn btn-success mb-3" onclick="window.location.href='../admin_products/add_product_form.php';">
            Add New Product
        </button>

        <!-- Category Selection -->
        <section class="mb-4">
            <h4>Select a Category</h4>
            <form action="" method="get" class="row g-2 align-items-center">
                <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                    <select name="categoryID" id="category" class="form-select" required>
                        <option value="">Select Category</option>
                        <option value="0">All Products</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category['categoryID']; ?>" 
                                <?php if ($categoryID == $category['categoryID']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($category['categoryName']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 col-sm-4 col-md-6 col-lg-2">
                    <button class="btn btn-danger " type="submit">Filter Categories</button>
                </div>
            </form>
        </section>

        <!-- Products Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Category</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
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
                                <td><?php echo htmlspecialchars($product['listPrice']); ?></td>
                                <td><?php echo htmlspecialchars($product['discountPercent']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- View Product Button -->
                                        <form action="../admin_products/product_view.php" method="get">
                                            <input type="hidden" name="productID" value="<?php echo  $product['productID']; ?>">
                                            <button type="submit" class="btn btn-info btn-sm">View</button>
                                        </form>
                                        <!-- Delete Button -->
                                        <form action="../admin_products/delete_product.php" method="post">
                                            <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                                            <input type="hidden" name="categoryID" value="<?php echo $product['categoryID']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center">No products available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
