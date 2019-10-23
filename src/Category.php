<?php

namespace Xak\Core;


class Category {
	private $id;
	private $name;
	private $products;


	public function __construct( $id, $name ) {
		$this->id   = $id;
		$this->name = $name;
	}


	public function getId() {
		return $this->id;
	}

	public function setId( ) {
		$categoryList = $this->getCategoryList();
		$lastId = ( empty( $categoryList['Categories'] ) ) ? 0 : $categoryList['Categories'][ count( $categoryList['Categories'] ) - 1 ]['id'];
		$this->id = ++$lastId;
	}

	public function getName() {
		return $this->name;
	}

	public function setName( $name ) {
		$this->name = $name;
	}

	public function getProducts() {
		return $this->products;
	}

	public function setProducts( $products ) {

		$file = file_get_contents( __DIR__ . '/../data/databese.json' );

		$categorytList = json_decode( $file, true );

		unset( $file );

		$categorytList['Category'];
	}

	private static function getCategoryList() {

		$file = file_get_contents( __DIR__ . '/../data/databese.json' );

		$categoryList = json_decode( $file, true );

		unset( $file );

		return $categoryList;
	}

	private static function saveCategory( $data ) {

		$categoryList = $data;

		return file_put_contents( __DIR__ . '/../data/databese.json', json_encode( $categoryList ) );
	}

	public function createCategory() {

		$this->setId();

		$data = array(
			'id'       => $this->id,
			'name'     => $this->name,
		);

		$categoryList = $this->getCategoryList();

		$categoryList['Categories'] = ( is_array( $categoryList['Categories'] ) ) ? $categoryList['Categories'] : array();

		$categoryList['Categories'][] = $data;

		$result = $this->saveCategory( $categoryList );

		if ( $result ) {
			return $data;
		} else {
			return false;
		}

	}

	public static function addProduct($productId, $categoryId){

		$categoryList = self::getCategoryList();

		foreach ($categoryList["Categories"] as $key=>$value){

			if($value['id'] == $categoryId){

				$categoryList["Categories"][$key]["products"][] = $productId;

				self::saveCategory($categoryList);
			}
		}

	}

	static function removeProduct($productId, $categoryId){

		$categoryList = self::getCategoryList();

		foreach ($categoryList["Categories"] as $key=>$value){

			if($value['id'] == $categoryId){

				$categoryList["Categories"][$key]["products"] = array_values(array_diff($categoryList["Categories"][$key]["products"], array($productId)));

				self::saveCategory($categoryList);
			}
		}

	}

	static function move($productId, $fromCategory, $toCategory){
		self::addProduct($productId, $toCategory);
		self::removeProduct($productId, $fromCategory);

		return $toCategory;
	}

	public static function getCategoryProducts($id){

		$categoryList = self::getCategoryList();

		foreach ($categoryList["Categories"] as $key=>$value){

			if($value['id'] == $id){
				$products = array();
				foreach ($categoryList["Categories"][$key]['products'] as $product)

					$products[] = Product::getProductById($product);
					return $products;
			}
		}
		return null;
	}


	public static function showProducts(){
		$categoryList = self::getCategoryList();

		$result = array();

		foreach ($categoryList["Categories"] as $category){

			$data = array(
				'name' => $category['name'],
				'products' => self::getCategoryProducts($category['id']),
			);
			$result[] = $data;
		}

		return $result;
	}
}