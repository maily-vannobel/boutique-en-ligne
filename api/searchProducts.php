<?php
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/ProductImages.php';

$products = new Products();
$productImages = new ProductImages();

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$allProducts = $products->searchProducts($searchTerm);

$result = [];
foreach ($allProducts as $product) {
    $images = $productImages->getImagesByProductId($product['product_id']);
    $product['images'] = $images;
    $result[] = $product;
}

header('Content-Type: application/json');
echo json_encode($result);
?>
