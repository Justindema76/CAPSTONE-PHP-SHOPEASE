<!-- views/product_view.php -->

<main class="container my-5">
  <div class="row product_view">
    <!-- Product Image -->
    <div class="col-md-6 text-center product-image">
      <?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

      // Check if the script is in the 'admin' directory
      $imagePath = (strpos($_SERVER['SCRIPT_NAME'], 'admin') !== false) ? '../../images/' : 'images/';

      if (!empty($product['imageName'])): ?>
          <!-- Show image with the correct path based on the script's location -->
          <img src="<?php echo htmlspecialchars($imagePath . $product['imageName']); ?>" 
               alt="<?php echo htmlspecialchars($product['productName']); ?>" 
               class="img-fluid rounded" style="max-width: 400px; height: auto;">
      <?php else: ?>
          <p class="text-muted">No image available for this product.</p>
      <?php endif; ?>
    </div>

    <!-- Product Details -->
    <div class="col-md-6 product-details">
      <p><strong>Category:</strong> <?php echo htmlspecialchars($product['categoryName']); ?></p>
      <p><strong>Product Code:</strong> <?php echo htmlspecialchars($product['productCode']); ?></p>
      <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product['productName']); ?></p>
      <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
      <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($product['listPrice'], 2)); ?></p>
      <p><strong>Discount Percent:</strong> <?php echo htmlspecialchars($product['discountPercent']); ?>%</p>

   <!-- Add to Cart Form -->
  <form action="cart.php" method="post" id="add_to_cart_form" class="mt-3">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="productID" value="<?php echo $product['productID']; ?>">  <!-- Product ID -->
    
    <label for="quantity"><strong>Quantity:</strong></label>
    <div class="d-flex align-items-center">
        <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-50" required>
        <button type="submit" class="ms-3">Add to Cart</button>
    </div>
</form>



      <p class="mt-4"><strong>Your Price:</strong> $<?php 
          // Calculate discount price
          $discountPrice = $product['listPrice'] * (1 - $product['discountPercent'] / 100);
          echo htmlspecialchars(number_format($discountPrice, 2)); 
      ?> (You save $<?php 
          $discountAmount = $product['listPrice'] - $discountPrice;
          echo htmlspecialchars(number_format($discountAmount, 2)); 
      ?>)</p>
    </div>
  </div>
</main>

