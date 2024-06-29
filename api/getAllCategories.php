<?php
require_once __DIR__ . '/../classes/Categories.php';

$categories = new Categories();
$allCategories = $categories->getAllCategories();

header('Content-Type: application/json');
echo json_encode($allCategories);
?>
