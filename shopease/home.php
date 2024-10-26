<?php
// session_start();
require("database.php");

// // Ensure the user is an admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: admin_login.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
       
    </style>
</head>
<body>
<?php include("view/sidebar.php"); ?>

    <div class="main-content">
    <h1>Welcome to ShopEase</h1>
         <!-- Main Content Area -->
         <section class="main-content">
            
            <div class="admin-links">
    <div class="admin-section">
        <h2>Catalog</h2>
        <a href="/catalog/index.php">Add / Edit Categories</a>
    </div>

    <div class="admin-section">
        <h2>Cart</h2>
        <a href="">Add / Edit Products</a>
    </div>

    
</div>

            </div>
        </section>
    </div>

    <script>

    </script>
</body>
</html>
