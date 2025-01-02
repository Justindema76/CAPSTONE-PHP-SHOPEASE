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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/.css">
</head>
<body>
    <?php include("../../view/admin_sidebar.php"); ?>
    <main class="container my-2">
      
        <section> 
             <h1 class="text-center mb-2">Product Manager - Edit Product Form</h1>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <form action="edit_product.php" method="post" id="edit_product_form" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <select name="categoryID" id="category" class="form-select" required>
                                <!-- Display the current category as the first option -->
                                <option value="<?php echo htmlspecialchars($product['categoryID'] ?? ''); ?>">
                                    <?php 
                                    foreach ($categories as $category) {
                                        if ($category['categoryID'] == ($product['categoryID'] ?? '')) {
                                            echo htmlspecialchars($category['categoryName']);
                                        }
                                    }
                                    ?>
                                </option>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo htmlspecialchars($category['categoryID']); ?>">
                                        <?php echo htmlspecialchars($category['categoryName']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Code:</label>
                            <input type="text" name="productCode" class="form-control" value="<?php echo htmlspecialchars($product['productCode'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Name:</label>
                            <input type="text" name="productName" class="form-control" value="<?php echo htmlspecialchars($product['productName'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description:</label>
                            <textarea name="description" rows="5" class="form-control" required><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price:</label>
                            <input type="text" name="listPrice" class="form-control" value="<?php echo htmlspecialchars(number_format($product['listPrice'] ?? 0, 2)); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount Percent:</label>
                            <input type="text" name="discountPercent" class="form-control" value="<?php echo htmlspecialchars($product['discountPercent'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock:</label>
                            <input type="text" name="stock" class="form-control" value="<?php echo htmlspecialchars($product['stock'] ?? ''); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Image:</label><br>
                            <img src="path/to/uploads/<?php echo htmlspecialchars($product['imageName'] ?? 'default-image.jpg'); ?>" alt="Product Image" class="img-thumbnail mb-2" width="150">
                            <input type="hidden" name="imageName" value="<?php echo htmlspecialchars($product['imageName'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload New Image (Optional):</label>
                            <input type="file" name="newImageName" class="form-control">
                        </div>
                        <input type="hidden" name="productID" value="<?php echo htmlspecialchars($product['productID']); ?>">
                        <div class="text-center">
                            <input type="submit" value="Submit" class="btn btn-primary w-50">
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
