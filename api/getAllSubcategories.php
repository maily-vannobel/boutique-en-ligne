<?php
require_once __DIR__ . '/../classes/Subcategories.php';

// Vérifiez si le fichier existe
if (!file_exists(__DIR__ . '/../classes/Subcategories.php')) {
    die('Le fichier Subcategories.php est manquant.');
}

header('Content-Type: application/json');

try {
    $subcategories = new Subcategories();
    $allSubcategories = $subcategories->getAllSubcategories();
    echo json_encode($allSubcategories);
} catch (Exception $e) {
    echo json_encode(['error' => 'Erreur lors du chargement des sous-catégories : ' . $e->getMessage()]);
}
?>
