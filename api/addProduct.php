<?php
session_start(); // Démarrer la session

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/Subcategories.php';
require_once __DIR__ . '/../classes/Images.php';
require_once __DIR__ . '/../classes/Filters.php';
require_once __DIR__ . '/../classes/ProductFilters.php';
require_once __DIR__ . '/../classes/ProductSubcategories.php';

$subcategories = new Subcategories();
$productFilters = new ProductFilters();
$products = new Products();
$filters = new Filters();
$images = new Images();
$productSubcategories = new ProductSubcategories();

$allFilters = $filters->getAllFilters();
$allSubcategories = $subcategories->getAllSubcategories();

if (isset($_GET['term'])) {
    $term = $_GET['term'];
    $results = $filters->searchFilters($term);
    echo json_encode($results);
    exit(); // Ajoutez un exit pour éviter de continuer l'exécution
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $quantity_weight = $_POST['quantity_weight'] ?? [];
    $price = $_POST['price'];
    $subcategories_ids = $_POST['subcategories'] ?? []; // Ajoutez une valeur par défaut
    $image_urls = $_POST['image_urls'] ?? []; // Ajoutez une valeur par défaut
    $selected_filters = $_POST['filters'] ?? [];
    $category_id = $_POST['category_id'];

    try {
        $product_id = $products->addProduct($product_name, $description, $quantity_weight, $price, $category_id);

        if ($product_id) {
            // Ajouter le produit à chaque sous-catégorie sélectionnée
            foreach ($subcategories_ids as $subcategory_id) {
                $productSubcategories->addProductToSubcategory($product_id, $subcategory_id);
            }

            // Ajouter des images
            foreach ($image_urls as $url) {
                $images->addImageToProduct($product_id, $url);
            }

            // Ajouter des filtres
            foreach ($selected_filters as $filter_id) {
                $productFilters->addFilterToProduct($product_id, $filter_id);
            }

            // Stocker le message de succès dans la session
            $_SESSION['success_message'] = "Produit '$product_name' ajouté avec succès !";

            // Rediriger vers le formulaire
            header('Location: /pages/addProductForm.php');
            exit();
        } else {
            echo "Erreur lors de l'ajout du produit.";
        }
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
}
?>
