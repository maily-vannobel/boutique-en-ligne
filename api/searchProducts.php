<?php
require_once __DIR__ . '/../classes/Products.php';

if (isset($_POST['term'])) {
    $products = new Products();
    $data = $products->searchProducts($_POST['term']);

    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
