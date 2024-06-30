<?php
require_once __DIR__ . '/../../classes/Subcategories.php';

$subcategories = new Subcategories();
$allSubcategories = $subcategories->getAllSubcategories();

echo json_encode($allSubcategories);
?>
