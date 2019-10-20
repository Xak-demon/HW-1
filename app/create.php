<?php

require_once __DIR__ . '/../vendor/autoload.php';

echo "create";

$product = new \Xak\Core\Product( 'Mouse', 'PC', 11, 6);

$productResult = $product->createProduct();

if($productResult){
	echo "\n was create product:\n";
	foreach ($productResult as $key => $value){
		echo "$key = $value\n";
	}
}else{
	echo "Oops, something went wrong";
}




