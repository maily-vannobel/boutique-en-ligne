<?php
require_once __DIR__ . '/../../classes/Categories.php';

$categories = new Categories();
$allCategories = $categories->getAllCategories();

echo json_encode($allCategories);
?>
