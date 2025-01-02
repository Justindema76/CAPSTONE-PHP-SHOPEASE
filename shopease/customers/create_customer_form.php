<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
require('../database.php');

// Fetch countries from the database for the dropdown
$queryCountries = 'SELECT countryCode, countryName FROM countries ORDER BY countryName';
$statement = $db->prepare($queryCountries);
$statement->execute();
$countries = $statement->fetchAll(PDO::FETCH_ASSOC);
$statement->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Customer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>
<body>
<?php include("../view/admin_sidebar.php"); ?>
    <main class="container mt-4">
        <h2 class="mb-4">Create New Customer</h2>
        
        <?php include("../view/customer.php"); ?>
        
        
    </main>
    <footer class="text-center mt-5">
        <p>&copy; 2024 ShopEase</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
