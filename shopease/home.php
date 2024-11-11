<?php
// session_start();
require("database.php");

// // Ensure the user is an admin
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: admin_login.php");
//     exit();
// }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShopEase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/home.css">
  </head>
  <body>

  <!--Nav Bar-->
    <nav class="navbar navbar-expand-xl navbar-light  py-3 fixed-top">
      <div class="container">
        <img class="logo" src="assets/images/logo.png" class="logo">
        <h2 class="logo-name">ShopEase</h2>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          
            <li class="nav-item">
              <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="shop.html">Shop</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Blog</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact Us</a>
            </li>
            <li  class="nav-item icons">
              <i class="fa-solid fa-cart-shopping"></i>
              <i class="fa-solid fa-user"></i>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!--Home-->
    <section id="home">
      <div class="container">
        <h2>NEW ARRIVALS</h2>
        <h1><span>Best Prices /</span> Sale on Now</h1>
        <h2><span></span> Get MORE for LESS</h2>
        <button>Shop Now</button>
      </div>
    </section>

 <!-- Brands -->
 <section id="brand" class="container-fluid py-3">
  <div class="row">
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brand1.png"/>
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brand2.jpg"/>
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brand3.png"/>
    <img class="img-fluid col-lg-3 col-md-6 col-sm-12" src="assets/images/brand4.png"/>
  </div>
</section>

    <!-- new  -->
    <section id="new">
      <div class="container text-center mt-3 py-3">
        <h2>Featured Products</h2>
        <hr>
        <h3>Check them Out!</h3>
      </div>
      <div class="container"> <!-- Added container to limit the width -->
        <div class="row">
          <!-- ONE -->
          <div class="tv one col-lg-3 col-md-6 col-sm-12 p-0">
            <img class="img-fluid" src="assets/images/tv.webp" />
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <div class="details">
              <h2>Save up to 40% on select smart TVs.</h2>
              <button class="text-uppercase">SHOP NOW</button>
            </div>
          </div>
          <!-- TWO -->
          <div class="one col-lg-3 col-md-6 col-sm-12 p-0">
            <img class="img-fluid" src="assets/images/laptop.jpg" />
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <div class="details">
              <h2>Save up to $400 on select laptops.</h2>
              <button class="text-uppercase">SHOP NOW</button>
            </div>
          </div>
          <!-- THREE -->
          <div class="one col-lg-3 col-md-6 col-sm-12 p-0">
            <img class="img-fluid" src="assets/images/Gaming-Consoles1.jpg" />
            <div class="star">
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
              <i class="fas fa-star"></i>
            </div>
            <div class="details">
              <h2>Save up to 40% on gaming consoles</h2>
              <button class="text-uppercase">SHOP NOW</button>
            </div>
          </div>
          <!-- FOUR -->
          <div class="one col-lg-3 col-md-12 col-sm-12 p-0">
            <img class="img-fluid" src="assets/images/appliances.webp" />
            <div class="star">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
      </div>
            <div class="details">
              <h2>Save up to $500 on select kitchen appliances</h2>
              <button class="text-uppercase">SHOP NOW</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- banner -->
<section id="banner" class="py-1">
  <div class="container">
    <h2>END OF SEASON</h2>
    <h1>Black Friday Deals</h1>
    <h2> UP to 40% OFF</h2>
    <button class="text-uppercase">SHOP NOW</button>
  </div>
</section>

   


<!-- footer -->
<footer >
  <div class="row container mx-auto pt-5">
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
      <img class="logo" src="assets/images/logo.png" alt="">
      <h2 class="logo-name">ShopEase</h2>
      <p class="pt-3">We provide the best products for the most affordable prices</p>
    </div>
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
      <h5 class="pb-2">Featured</h5>
      <ul class="text-uppercase">
        <li><a href="#">smart TVs</a></li>
        <li><a href="#">computers & laptops</a></li>
        <li><a href="#">gaming</a></li>
        <li><a href="#">appliances</a></li>
        <li><a href="#">new arrivals</a></li>
        <li><a href="#">sales & clearance</a></li>
      </ul>
    </div>
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
      <h5 class="pb-2">Contact Us</h5>
      <div>
        <h6 class="text-uppercase">address</h6>
        <p>1235 Street Name, City</p>
      </div>
      <div>
        <h6 class="text-uppercase">phone</h6>
        <p>1-289-568-8798</p>
      </div>
      <div>
        <h6 class="text-uppercase">email</h6>
        <p>email@email.com</p>
      </div>
    </div>
    <div class="footer-one col-lg-3 col-md-6 col-sm-12">
      <h5 class="pd-2">Featured Brands</h5>
      <div class="row">
        <img src="assets/images/brand1.png" class="img-fluid w-25 h-100 m-2">
        <img src="assets/images/brand2.jpg" class="img-fluid w-25 h-100 m-2">
        <img src="assets/images/brand3.png" class="img-fluid w-25 h-100 m-2">
        <img src="assets/images/brand4.png" class="img-fluid w-25 h-100 m-2">
        
      </div>
    </div>
  </div>
<div class="copyright mt-5">
  <div class="row container mx-auto">
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
      <img src="assets/images/payment.png">
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4 text-nowrap mb-2">
      <p>eCommerce @2025 All rights reserved</p>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
    </div>
  </div>
</div>
</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>