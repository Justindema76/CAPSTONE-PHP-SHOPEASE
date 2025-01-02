<?php

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ShopEase</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<style>.logo-link {
  text-decoration: none; /* Removes underline from the link */
  color: inherit; /* Ensures the text color stays the same */
}

.nav-buttons{
margin-left: 50%;
color: #d00;
}
.logo-container {
  display: flex; /* Makes children inline */
  align-items: center; /* Vertically align items */
}
.logo {
  width: 40px;
  height: 40px;
  margin-right: 8px; /* Add space between logo and text */
}

.logo-name {
  color: #d00;
  font-size: 1.5rem; /* Adjust size as needed */
  margin: 0; /* Remove extra margin around text */
}
.navbar{
  font-size: 1.0rem;
  padding-top: 2rem !important;
  padding-bottom: 2rem !important;
  top: 0;
  left: 0;
  background-color:white;
  box-shadow: 0 5px 10px rgb(0, 0, 0, .1);
  height: 75px;
}

.navbar-light .navbar-nav .nav-link{
  padding: 0 10px;
  columns: #000;
  transition: 0.4s ease;
}

.navbar-nav .nav-link {
  color: #d00; 
}

.navbar-light .navbar-nav .nav-link:hover,
.navbar i:hover,
.navbar-light .navbar-nav .nav-link.active
.navbar i:hover{
  color: #000;
  text-decoration: underline;
  text-underline-offset: 5px;
}
/* Remove underline on .icons */
.navbar-light .navbar-nav .icons i:hover {
  text-decoration: none;
}

.navbar i{
  font-size: 1.0rem;
  padding: 0 10px;
  transition: 0.4s ease;
  cursor: pointer;
}


/* Remove default blue color from the link */
.nav-item a {
  color: #d00; /* Red color for the icon */
  text-decoration: none; /* Remove the underline */
}

/* Change color of the icon inside the link */
.nav-item a i {
  color: inherit; /* Ensure the icon inherits the link color */
}

/* Hover effect to turn the icon black */
.nav-item a:hover i {
  color: #000000; /* Change icon color to black on hover */
}

.icons:hover i {
  color: #000000; /* Change the icon color to black on hover */
}


.navbar-toggler:hover {
  background-color: white; /* Sets the background to white */
  color: black; /* Optional: changes text/icon color */
  border-color: white; /* Optional: changes border color */
}
@media only screen and (min-width: 992px) and (max-width: 1280px){
  .nav-buttons{
    margin: 5px;
  }
  .nav-buttons ul{
    margin: 1rem;
    justify-content: flex-start;
    align-items: flex-start;
    text-align: left;
  }

  .nav-buttons ul .fas{
    margin: 20px 5px 10px 20px;
  }
}


</style>
<!-- Nav Bar -->
<nav class="navbar navbar-expand-xl navbar-light py-3 fixed-top">
  <div class="container">
  <a href="/capstone-shopease/shopease/home.php" class="logo-link">
  <div class="logo-container">
    <img class="logo" src="assets/images/logo.png" alt="Logo">
    <h2 class="logo-name">ShopEase</h2>
  </div>
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/capstone-shopease/shopease/home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/capstone-shopease/shopease/shop.php">Shop</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/capstone-shopease/shopease/admin/index.php">Admin</a>
        </li>
        
          <?php if (isset($_SESSION['firstName'])): ?>
            <!-- Show customer's name if logged in -->
            <span class="nav-item login" style="color: #000;">
            Hello, <?php echo htmlspecialchars($_SESSION['firstName']); ?>
          </span>

          <?php else: ?>
            <!-- Show login icon if not logged in -->
             <li class="nav-item">
            <a href="/capstone-shopease/shopease/login.php">
              <i class="fa-solid fa-user"></i>
            </a>
            
          <?php endif; ?>
        </li>
        <li class="nav-item icons">
  <?php if (isset($_SESSION['firstName'])): ?>
    <!-- Link to customer-cart.php if the customer is logged in -->
    <a href="/capstone-shopease/shopease/customer-cart.php">
      <i class="fa-solid fa-cart-shopping"></i>
    </a>
  <?php else: ?>
    <!-- Link to cart.php if the customer is not logged in -->
    <a href="/capstone-shopease/shopease/cart.php">
      <i class="fa-solid fa-cart-shopping"></i>
    </a>
  <?php endif; ?>
</li>

          <li class="nav-item icons">
  <?php if (isset($_SESSION['firstName'])): ?>
    <!-- Show logout icon if logged in -->
    <a href="/capstone-shopease/shopease/logout.php">
      <i class="fa-solid fa-sign-out-alt"></i>
    </a>
  <?php endif; ?>
</li>

      </ul>
    </div>
  </div>
</nav>
</body>
</html>
