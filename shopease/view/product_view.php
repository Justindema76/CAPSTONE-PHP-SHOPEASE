        <h1>Product Manager - View Product</h1>
        <div class="product_view">
            <div class="product-image">
            <?php if (!empty($product['imageName'])): ?>
    
            <img src="<?php echo htmlspecialchars('../../images/' . $product['imageName']); ?>" alt="<?php echo htmlspecialchars($product['productName']); ?>" style="width:400px;height:auto;">
            <?php else: ?>
            <p>No image available for this product.</p>
            <?php endif; ?>

            </div>
            <div class="product-details">
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['categoryName']); ?></p>
                <p><strong>Product Code:</strong> <?php echo htmlspecialchars($product['productCode']); ?></p>
                <p><strong>Product Name:</strong> <?php echo htmlspecialchars($product['productName']); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars(number_format($product['listPrice'], 2)); ?></p>
                <p><strong>Discount Percent:</strong> <?php echo htmlspecialchars($product['discountPercent']); ?>%</p>

                <!-- Add to Cart Form -->
                <form action="<?php echo $app_path . 'cart'; ?>" method="post" id="add_to_cart_form">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product['productID']; ?>">
                    <b>Quantity:</b>
                    <input type="number" name="quantity" value="1" min="1" size="2" required>
                    <input type="submit" value="Add to Cart">
                </form>

                <p><strong>Your Price:</strong> $<?php 
                    // Calculate discount price
                    $discountPrice = $product['listPrice'] * (1 - $product['discountPercent'] / 100);
                    echo htmlspecialchars(number_format($discountPrice, 2)); 
                ?> (You save $<?php 
                    $discountAmount = $product['listPrice'] - $discountPrice;
                    echo htmlspecialchars(number_format($discountAmount, 2)); 
                ?>)</p>