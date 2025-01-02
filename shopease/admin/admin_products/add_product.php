<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../../database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form input values
    $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_SANITIZE_NUMBER_INT);
    $productCode = filter_input(INPUT_POST, 'productCode', FILTER_SANITIZE_STRING);
    $productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $listPrice = filter_input(INPUT_POST, 'listPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $discountPercent = filter_input(INPUT_POST, 'discountPercent', FILTER_SANITIZE_NUMBER_INT);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);

    // Handle file input
    $imageName = isset($_FILES['imageName']['name']) ? $_FILES['imageName']['name'] : null;

    // Validate required fields
    if (empty($categoryID) || empty($productCode) || empty($productName) || empty($listPrice)) {
        echo "Error: Missing required fields.";
        exit();
    }
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $fileExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        echo "Error: Only image files are allowed.";
        exit();
    }


    // Prepare SQL query
    try {
        $query = "
            INSERT INTO products 
            (categoryID, productCode, productName, description, listPrice, discountPercent, stock, imageName) 
            VALUES 
            (:categoryID, :productCode, :productName, :description, :listPrice, :discountPercent, :stock, :imageName)
        ";

        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->bindValue(':productCode', $productCode);
        $statement->bindValue(':productName', $productName);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':listPrice', $listPrice);
        $statement->bindValue(':discountPercent', $discountPercent);
        $statement->bindValue(':stock', $stock);
        $statement->bindValue(':imageName', $imageName); // Store file name only

        $statement->execute();
        $statement->closeCursor();

        // Redirect after successful insert
        header("Location: ../../admin/admin_products/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit();
    }
}
