<?php

require_once __DIR__.'/../vendor/autoload.php';

$product = new \Xak\Core\Product(13);

if (false !== ($category = \Xak\Core\Category::move($product->getId(), $product->getCategory(), 3))) {
    $product->updateCategory($category);
}

$categoryProducts = \Xak\Core\Category::showProducts();

foreach ($categoryProducts as $category) {
    echo "\n";
    echo 'Category - '.$category['name'];
    echo "\n";

    foreach ($category['products'] as $product) {
        echo '  id - '.$product['id']."\n";
        echo '  name - '.$product['name']."\n";
        echo '  price - '.$product['price']."\n";
        echo '  quantity - '.$product['name']."\n";
        echo '============';
        echo "\n";
    }
}
