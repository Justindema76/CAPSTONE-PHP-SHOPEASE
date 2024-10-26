<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection and utility functions
require("../../database.php");
require('../../util/image_util.php');

$image_dir = '../../images';
$image_dir_path = getcwd() . DIRECTORY_SEPARATOR . $image_dir;

// Initialize variables
$imageName = null;

// Handle the image upload before processing the form
if (isset($_FILES['file1'])) {
    $filename = $_FILES['file1']['name'];
    if (!empty($filename)) {
        $source = $_FILES['file1']['tmp_name'];
        $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;

        if (move_uploaded_file($source, $target)) {
            echo "File uploaded successfully!<br>";
            $imageName = $filename; // Store the image name for later use
            if (file_exists($target)) {
                echo "File is located at: " . htmlspecialchars($target) . "<br>";
            } else {
                echo "File was not found at target location.<br>";
            }
            process_image($image_dir_path, $filename); // Process the image if needed
        } else {
            echo "Failed to upload file.<br>";
        }
    } else {
        echo "No file uploaded.<br>";
    }
}

// Handle product submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $categoryID = isset($_POST['categoryID']) ? $_POST['categoryID'] : null;
    $productCode = isset($_POST['productCode']) ? $_POST['productCode'] : null;
    $productName = isset($_POST['productName']) ? trim($_POST['productName']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $listPrice = isset($_POST['listPrice']) ? floatval($_POST['listPrice']) : 0.0;
    $discountPercent = isset($_POST['discountPercent']) ? floatval($_POST['discountPercent']) : 0.0;
    $stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;

    // Check if productCode already exists
    $checkQuery = 'SELECT COUNT(*) FROM products WHERE productCode = :productCode';
    $checkStatement = $db->prepare($checkQuery);
    $checkStatement->bindValue(':productCode', $productCode);
    $checkStatement->execute();
    $productExists = $checkStatement->fetchColumn();
    $checkStatement->closeCursor();

    if ($productExists) {
        // Product code already exists, handle the error (e.g., display a message)
        echo "Error: Product code already exists.";
    } else {
        // Prepare the INSERT query based on whether an image was uploaded
        if ($imageName) {
            // Insert product into the database with image
            $query = 'INSERT INTO products
                         (categoryID, productCode, productName, description, listPrice, discountPercent, stock, imageName)
                      VALUES
                         (:categoryID, :productCode, :productName, :description, :listPrice, :discountPercent, :stock, :imageName)';
        } else {
            // Insert product into the database without image
            $query = 'INSERT INTO products
                         (categoryID, productCode, productName, description, listPrice, discountPercent, stock)
                      VALUES
                         (:categoryID, :productCode, :productName, :description, :listPrice, :discountPercent, :stock)';
        }

        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->bindValue(':productCode', $productCode);
        $statement->bindValue(':productName', $productName);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':listPrice', $listPrice);
        $statement->bindValue(':discountPercent', $discountPercent);
        $statement->bindValue(':stock', $stock);
        
        // Bind the image name only if it exists
        if ($imageName) {
            $statement->bindValue(':imageName', $imageName);
        }

        $statement->execute();
        $statement->closeCursor();

        // Redirect back to the manage products page
        header("Location: ../../admin/admin_products/index.php");
        exit();
    }
}

// Later in the product view...
if (!empty($product['imageName'])) {
    // Display the image by pointing to the images directory
    $imagePath = '../images/' . $product['imageName'];
    if (file_exists($imagePath)) {
        echo '<img src="' . htmlspecialchars($imagePath) . '" alt="' . htmlspecialchars($product['productName']) . '" style="width:200px;height:auto;">';
    } else {
        echo '<p>No image available for this product. (Image path does not exist)</p>';
    }
} else {
    echo '<p>No image available for this product.</p>';
}

?>
