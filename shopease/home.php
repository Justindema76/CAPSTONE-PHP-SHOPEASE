<?php
// session_start();
require("database.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
    <link rel="stylesheet" href="css/shop.css">
  
  <body>

  <?php include("view/navbar.php"); ?>

    <!--Home-->
    <section id="home">
      <div class="container">
        <h2>NEW ARRIVALS</h2>
        <h1><span>Best Prices /</span> Sale on Now</h1>
        <h2><span></span> Get MORE for LESS</h2>
        <a href="shop.php">
        <button class="text-uppercase">SHOP NOW</button>
        </a>
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
              <a href="shop.php">
              <button class="text-uppercase">SHOP NOW</button>
              </a>
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
              <a href="shop.php">
              <button class="text-uppercase">SHOP NOW</button>
              </a>
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
              <a href="shop.php">
              <button class="text-uppercase">SHOP NOW</button>
              </a>
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
              <a href="shop.php">
              <button class="text-uppercase">SHOP NOW</button>
              </a>
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
    <a href="shop.php">
  <button class="text-uppercase">SHOP NOW</button>
</a>

  </div>
</section>

   
  <!-- Footer -->
  <?php include("view/footer.php"); ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
