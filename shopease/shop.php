<!-- shop.php -->

<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection and utility functions
require_once('database.php');
require_once('util/tags.php');

// Check if the database connection exists
if (!$db) {
    die("Database connection failed.");
}


// Handle add to cart
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $productID = $_POST['productID']; // Get the product ID
    $quantity = $_POST['quantity'];   // Get the quantity

    // Add the product to the cart (simplified example)
    $_SESSION['cart'][$productID] = $quantity;

    // Redirect back to the shop page after adding the product
    header('Location: shop.php');
    exit();
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
    <title>Shop</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/shop.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <?php include("view/navbar.php"); ?>

    <!-- Main Content -->
    <main class="container py-5">

        <!-- Category Selection -->
        <section class="mb-4">
            <h2 class="mb-3">Select a Category</h2>
            <form action="" method="get" class="d-flex gap-2">
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
                <button class="text-uppercase">Filter</button>
            </form>
        </section>
        
        <!-- Product Cards -->
        <div class="row g-4">
        <?php if (count($productData) > 0) : ?>
        <?php foreach ($productData as $product) : ?>
    <div class="col-lg-3 col-md-6 col-sm-12">
        
    <div class="card h-100">
            <!-- Display the product image -->
            <?php if (!empty($product['imageName'])): ?>
                <div id="new">
                <img src="<?php echo htmlspecialchars('images/' . $product['imageName']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>" class="one img-fluid" >
            </div>
            <?php else: ?>
                <p>No image available</p>
            <?php endif; ?>

            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($product['productName']); ?></h5>
                <p class="card-text">Price: $<?php echo htmlspecialchars($product['listPrice']); ?></p>
                <p class="card-text">Discount: <?php echo htmlspecialchars($product['discountPercent']); ?>%</p>
                <p class="card-text"><?php echo htmlspecialchars($product['categoryName']); ?></p>
                <!-- View Product Button (Preserving your button classes) -->
                <form action="shop_view.php" method="get">
                    <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">
                    <button class="text-uppercase">View</button>
                </form>

            </div>
        </div>
    </div>
       
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12 text-center">
                    <p>No products available.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include("view/footer.php"); ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
