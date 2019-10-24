<?php

require_once __DIR__.'/../vendor/autoload.php';

$product = new \Xak\Core\Product('Mouse5', 1, 11, 6);

$productResult = $product->createProduct();

if ($productResult) {
    echo "\n was create product:\n";
    foreach ($productResult as $key => $value) {
        echo "$key = $value\n";
    }
} else {
    echo 'Oops, something went wrong';
}
