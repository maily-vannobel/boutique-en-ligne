<?php
require_once __DIR__ . '/../classes/Filters.php';

$filters = new Filters();
$allFilters = $filters->getAllFilters();

header('Content-Type: application/json');
echo json_encode($allFilters);
?>
