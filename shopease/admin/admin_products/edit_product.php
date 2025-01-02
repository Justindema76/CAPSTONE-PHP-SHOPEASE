<?php
// Display errors for debugging (remove this in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize the input data
    $productID = filter_input(INPUT_POST, 'productID', FILTER_SANITIZE_NUMBER_INT);
    $categoryID = filter_input(INPUT_POST, 'categoryID', FILTER_SANITIZE_NUMBER_INT);
    $productCode = filter_input(INPUT_POST, 'productCode', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $productName = filter_input(INPUT_POST, 'productName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $listPrice = filter_input(INPUT_POST, 'listPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $discountPercent = filter_input(INPUT_POST, 'discountPercent', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);

    // Handle image name as a string input
    $imageName = filter_input(INPUT_POST, 'imageName', FILTER_SANITIZE_STRING);

    // Validate required fields
    $errors = [];
    if (!$productID) $errors[] = 'Product ID is required.';
    if (!$categoryID) $errors[] = 'Category ID is required.';
    if (!$productCode) $errors[] = 'Product code is required.';
    if (!$productName) $errors[] = 'Product name is required.';
    if (!$description) $errors[] = 'Description is required.';
    if ($listPrice === false) $errors[] = 'List price is required and must be a valid number.';
    if ($discountPercent === false) $errors[] = 'Discount percent is required and must be a valid number.';
    if (!$stock) $errors[] = 'Stock is required.';
    if (!$imageName) $errors[] = 'Image Name is required.'; // image name validation
    
    if (empty($errors)) {
        // Database connection
        require("../../database.php");

        // Prepare SQL UPDATE statement
        $query = 'UPDATE products
                  SET categoryID = :categoryID, productCode = :productCode, productName = :productName, 
                      description = :description, listPrice = :listPrice, discountPercent = :discountPercent, stock = :stock, imageName = :imageName
                  WHERE productID = :productID';

        $statement = $db->prepare($query);

        // Bind parameters
        $statement->bindValue(':productID', $productID, PDO::PARAM_INT);
        $statement->bindValue(':categoryID', $categoryID, PDO::PARAM_INT);
        $statement->bindValue(':productCode', $productCode, PDO::PARAM_STR);
        $statement->bindValue(':productName', $productName, PDO::PARAM_STR);
        $statement->bindValue(':description', $description, PDO::PARAM_STR);
        $statement->bindValue(':listPrice', $listPrice, PDO::PARAM_STR);
        $statement->bindValue(':discountPercent', $discountPercent, PDO::PARAM_STR);
        $statement->bindValue(':stock', $stock, PDO::PARAM_INT);
        $statement->bindValue(':imageName', $imageName, PDO::PARAM_STR); // Bind the imageName string

        // Execute the statement with error handling
        try {
            if ($statement->execute()) {
               
                header('Location: index.php');
                exit();
            } else {
                echo 'Error updating product.';
            }
        } catch (PDOException $e) {
            // Log error message to file or display
            error_log("Database error: " . $e->getMessage());
            echo 'There was an error updating the product. Please try again later.';
        }

        // Close the database connection
        $statement->closeCursor();
    } else {
        // Output validation errors
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
} else {
    // If not a POST request, return an error
    echo 'Invalid request method.';
    exit();
}
?>
