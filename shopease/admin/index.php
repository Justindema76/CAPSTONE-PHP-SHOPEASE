<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="text-center">
            <h1>Welcome to the ShopEase Admin Dashboard</h1>
        </div>
        
        <!-- Main Content Area -->
        <section class="mt-4">
            <div class="row">
                <!-- Admin Links Section -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Categories</h5>
                            <a href=" ../admin/categories/categories_form.php" class="btn btn-primary w-100">Add / Edit Categories</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Products</h5>
                            <a href="../admin/admin_products/index.php" class="btn btn-primary w-100">Add / Edit Products</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Orders</h5>
                            <a href="admin_orders/index.php" class="btn btn-primary w-100">View / Edit Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Customers</h5>
                            <a href="../customers/manage_customers_form.php" class="btn btn-primary w-100">View / Edit Users</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Manage Admin</h5>
                            <a href="manage_admin.php" class="btn btn-primary w-100">View / Edit Admins</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">ShopEase</h5>
                            <a href="../home.php" class="btn btn-primary w-100">View Main Store</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Add Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
