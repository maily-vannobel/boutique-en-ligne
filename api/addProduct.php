<?php
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $stock = $_POST['stock'];
    $ingredients = $_POST['ingredients'];
    $quantity_weight = $_POST['quantity_weight'];
    $price = $_POST['price'];
    $subcategories_id = $_POST['subcategories_id'];
    $image_urls = $_POST['image_urls'];
    $selected_filters = $_POST['filters'];

    $product_id = $products->addProduct($product_name, $description, $stock, $ingredients, $quantity_weight, $price);

    if ($product_id) {
        // Ajouter le produit à la sous-catégorie
        $productSubcategories->addProductToSubcategory($product_id, $subcategories_id);

        // Ajouter des images
        foreach ($image_urls as $url) {
            $images->addImageToProduct($product_id, $url);
        }

        // Ajouter des filtres
        foreach ($selected_filters as $filter_id) {
            $productFilters->addFilterToProduct($product_id, $filter_id);
        }

        echo "Produit ajouté avec succès !";
    } else {
        echo "Erreur lors de l'ajout du produit.";
    }
}
?>
