<?php
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/ProductFilters.php';
require_once __DIR__ . '/../classes/ProductImages.php';
require_once __DIR__ . '/../classes/ProductSubcategories.php';

$data = json_decode(file_get_contents('php://input'), true);

// Ajout de journalisation pour déboguer
file_put_contents('php://stderr', "Données reçues : " . print_r($data, true));

if (isset($data['id'])) {
    $productId = $data['id'];

    $productsClass = new Products();
    $productFiltersClass = new ProductFilters();
    $productImagesClass = new ProductImages();
    $productSubcategoriesClass = new ProductSubcategories();

    try {
        // Supprimer les filtres associés
        $productFiltersClass->removeAllFiltersFromProduct($productId);
        
        // Supprimer les images associées
        $productImagesClass->removeAllImagesFromProduct($productId);
        
        // Supprimer les sous-catégories associées
        $productSubcategoriesClass->removeProductFromAllSubcategories($productId);

        // Supprimer le produit
        $rowCount = $productsClass->deleteProduct($productId);

        $message = $rowCount > 0 ? 'Produit supprimé avec succès' : 'Erreur lors de la suppression du produit';
        header('Content-Type: application/json');
        echo json_encode(['message' => $message]);
    } catch (Exception $e) {
        file_put_contents('php://stderr', "Erreur : " . $e->getMessage());
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Erreur : ' . $e->getMessage()]);
    }
} else {
    file_put_contents('php://stderr', "ID de produit non fourni");
    header('Content-Type: application/json');
    echo json_encode(['message' => 'ID de produit non fourni']);
}
?>