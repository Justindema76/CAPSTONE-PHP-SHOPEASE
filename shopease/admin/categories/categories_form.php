<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('../../database.php');
// Get the database connection


$queryCategories = 'SELECT * FROM categories ORDER BY categoryID';
$statementCategories = $db->prepare($queryCategories);
$statementCategories->execute();
$categories = $statementCategories->fetchAll();
$statementCategories->closeCursor();

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

<main>
    <h2>Manage Categories</h2>

    <!-- Error message (if any) -->
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <br>


    <!-- Form to Add Category -->
    <form action="../categories/add_category.php" method="post" id="add_category_form">
        <label for="name">Add Category:</label>
        <input type="text" name="name" id="name" required />
        <input id="form_button" type="submit" class="btn btn-danger btn-sm" value="Add" />
    </form>

    <h1 class="my-4">Category List</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col">Category Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Display categories in the table -->
            <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?php echo htmlspecialchars($category['categoryName']); ?></td>
                <td>
                    <!-- Form for deleting a category -->
                    <form action="../categories/delete_category.php" method="post" style="display:inline;">
                        <input type="hidden" name="categoryID" value="<?php echo htmlspecialchars($category['categoryID']); ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>    
        </tbody>
    </table>
</div>

</main>
</body>
</html>
