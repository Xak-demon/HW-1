<?php

namespace Xak\Core;


class Product {

	private $id;
	private $name;
	private $category;
	private $price;
	private $quantity;

	/**
	 * Product constructor.
	 *
	 * @param $name
	 * @param $category
	 * @param $price
	 * @param $quantity
	 */
	public function __construct($name='', $category='', $price='', $quantity='') {

		$count = func_num_args();
		$params = func_get_args();

		if ($count == 1){
			$product =self::getProductById($params[0]);
			$this->name     = $product['name'];
			$this->category = $product['category'];
			$this->price    = $product['price'];
			$this->quantity = $product['quantity'];
			$this->id = $product['id'];
		}

		if($count ==4){
			$this->name     = $params[0];
			$this->category = $params[1];
			$this->price    = $params[2];
			$this->quantity = $params[3];
			$this->setId();
		}
	}


	public function getId() {
		return $this->id;
	}


	public function setId() {

		$productList = $this->getProductList();
		$lastId = ( empty( $productList['Products'] ) ) ? 0 : $productList['Products'][ count( $productList['Products'] ) - 1 ]['id'];
		$this->id = ++ $lastId;

	}

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function getCategory() {
		return $this->category;
	}

	public function setCategory( $category ) {
		$this->category = $category;
	}

	public function getPrice() {
		return $this->price;
	}

	public function setPrice( $price ) {
		$this->price = $price;
	}

	public function getQuantity() {
		return $this->quantity;
	}

	public function setQuantity( $quantity ) {
		$this->quantity = $quantity;
	}


	static function getProductById( $id ) {

		$productList = self::getProductList();

		foreach ($productList["Products"] as $key=>$value){

			if($value['id'] == $id){
				return $productList["Products"][$key];
			}
		}
		return null;
	}

	private static function saveProduct( $data ) {

		$productList = $data;

		return file_put_contents( __DIR__ . '/../data/databese.json', json_encode( $productList ) );
	}

	public function createProduct() {

		$data = array(
			'id'       => $this->id,
			'name'     => $this->name,
			'category' => $this->category,
			'price'    => $this->price,
			'quantity' => $this->quantity
		);

		$productList = self::getProductList();

		$productList['Products'] = ( is_array( $productList['Products'] ) ) ? $productList['Products'] : array();

		$productList['Products'][] = $data;

		$result = self::saveProduct( $productList );

		Category::addProduct($this->id, $this->category);

		if ( $result ) {
			return $data;
		} else {
			return false;
		}

	}

	private static function getProductList() {

		$file = file_get_contents( __DIR__ . '/../data/databese.json' );

		$productList = json_decode( $file, true );

		unset( $file );

		return $productList;
	}

	public function updateCategory($categoryId){

		$productList = self::getProductList();

		foreach ($productList["Products"] as $key=>$value) {

			if ( $value['id'] == $this->id ) {
				$productList["Products"][ $key ]["category"] = $categoryId;
				$this->setCategory($categoryId);
				self::saveProduct( $productList );

				return $this;
			}
		}
	}
}