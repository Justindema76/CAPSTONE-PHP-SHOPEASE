
<section>
    <h1><?php echo $current_category->getName(); ?></h1>
    <?php if (count($products) == 0) : ?>
        <ul><li>There are no products in this category.</li></ul>
    <?php else: ?>
        <ul>
        <?php foreach ($products as $product) : ?>
        <li>
            <a href="?action=view_product&amp;productID=<?php
                      echo $product->getID(); ?>">
                <?php echo $product->getName(); ?>
            </a>
        </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
