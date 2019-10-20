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

	private function getCategoryList() {

		$file = file_get_contents( __DIR__ . '/../data/databese.json' );

		$categoryList = json_decode( $file, true );

		unset( $file );

		return $categoryList;
	}

	private function saveCategory( $data ) {

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
}