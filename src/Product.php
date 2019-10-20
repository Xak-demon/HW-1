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
	public function __construct( $name, $category, $price, $quantity ) {
		$this->name     = $name;
		$this->category = $category;
		$this->price    = $price;
		$this->quantity = $quantity;
		$this->setId();
	}


	public function getId() {
		return $this->id;
	}


	public function setId() {

		$productList = $this->getProductList();
		$lastId = ( empty( $productList ) ) ? 0 : $productList[ count( $productList ) - 1 ]['id'];
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

	public function move() {

	}

	public function getProduct( $id ) {
		$file = file_get_contents( __DIR__ . '/../data/databese.json' );
		$productList = json_decode( $file, true );
		$productList = ( is_array( $productList ) ) ? $productList : array();
		unset( $file );

	}

	private function saveProduct( $data ) {

		$productList['Products'] = $data;

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

		$productList = $this->getProductList();

		$productList = ( is_array( $productList ) ) ? $productList : array();

		$productList[] = $data;

		$result = $this->saveProduct( $productList );

		if ( $result ) {
			return $data;
		} else {
			return false;
		}

	}

	private function getProductList() {

		$file = file_get_contents( __DIR__ . '/../data/databese.json' );

		$productList = json_decode( $file, true );

		unset( $file );

		return $productList['Products'];
	}
}