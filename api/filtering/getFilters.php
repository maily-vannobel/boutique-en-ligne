<?php
require_once __DIR__ . '/../../classes/Filters.php';

$filters = new Filters();
$allFilters = $filters->getAllFilters();

echo json_encode($allFilters);
?>
