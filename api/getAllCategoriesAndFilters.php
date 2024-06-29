<?php
require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/Filters.php';
require_once __DIR__ . '/../classes/Subcategories.php';

$categories = new Categories();
$filters = new Filters();
$subcategories = new Subcategories();

$allCategories = $categories->getAllCategories();
$allFilters = $filters->getAllFilters();
$allSubcategories = $subcategories->getAllSubcategories();

header('Content-Type: application/json');
echo json_encode([
    'categories' => $allCategories,
    'filters' => $allFilters,
    'subcategories' => $allSubcategories
]);
?>
