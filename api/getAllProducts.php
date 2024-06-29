<?php
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/Filters.php';
require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/ProductImages.php';

$productsClass = new Products();
$filtersClass = new Filters();
$categoriesClass = new Categories();
$productImagesClass = new ProductImages();

$products = $productsClass->getAllProducts();

foreach ($products as &$product) {
    $product['filters'] = $filtersClass->getFiltersByProductId($product['product_id']);
    $product['images'] = $productImagesClass->getImagesByProductId($product['product_id']);
    $category = $categoriesClass->getCategoryById($product['category_id']);
    $product['category_name'] = $category ? $category['category_name'] : 'N/A';
}

header('Content-Type: application/json');
echo json_encode($products);
?>
