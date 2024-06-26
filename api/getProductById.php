<?php
require_once __DIR__ . '/../classes/Products.php';

if (isset($_GET['id'])) {
    $products = new Products();
    $data = $products->getProductById($_GET['id']);

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
