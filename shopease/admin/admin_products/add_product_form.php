<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../database.php');

// Fetch categories from the database
$queryCategories = 'SELECT * FROM categories';
$statement = $db->prepare($queryCategories);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_ASSOC); // Fetch categories as an associative array
$statement->closeCursor();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include("../../view/admin_sidebar.php"); ?>

<div class="container mt-5">
    <main class="card p-4 shadow-sm">
        <h1 class="mb-4">Add New Product</h1>

        <!-- Display errors, if any -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form for adding a new product -->
        <form action="add_product.php" method="post" enctype="multipart/form-data" class="row g-3">
            
            <!-- Category -->
            <div class="col-md-6">
                <label for="category" class="form-label">Category: *</label>
                <select name="categoryID" id="category" class="form-select" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category['categoryID']); ?>">
                            <?php echo htmlspecialchars($category['categoryName']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Product Code -->
            <div class="col-md-6">
                <label for="productCode" class="form-label">Product Code: *</label>
                <input type="text" name="productCode" id="productCode" class="form-control" required>
            </div>

            <!-- Product Name -->
            <div class="col-md-6">
                <label for="productName" class="form-label">Product Name: *</label>
                <input type="text" name="productName" id="productName" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="col-md-12">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
            </div>

            <!-- Price -->
            <div class="col-md-4">
                <label for="listPrice" class="form-label">Price: *</label>
                <input type="number" name="listPrice" id="listPrice" class="form-control" step="0.01" required>
            </div>

            <!-- Discount -->
            <div class="col-md-4">
                <label for="discountPercent" class="form-label">Discount (%):</label>
                <input type="number" name="discountPercent" id="discountPercent" class="form-control" step="0.01">
            </div>

            <!-- Stock -->
            <div class="col-md-4">
                <label for="stock" class="form-label">Stock Quantity: *</label>
                <input type="number" name="stock" id="stock" class="form-control" required>
            </div>

            <!-- Image Upload -->
            <div class="col-md-12">
                <label for="imageName" class="form-label">Choose an Image:</label>
                <input type="file" name="imageName" id="imageName" class="form-control">
            </div>

            <!-- Submit Button -->
            <div class="col-12">
                <button type="submit" class="btn btn-danger w-100">Add Product</button>
            </div>
        </form>
    </main>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
