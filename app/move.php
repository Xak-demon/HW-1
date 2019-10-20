<?php
require_once __DIR__ . '/../vendor/autoload.php';

$category = new \Xak\Core\Category(1, 'Eat');

$category->createCategory();
