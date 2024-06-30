<?php
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/ProductFilters.php';
require_once __DIR__ . '/../classes/ProductSubcategories.php';
require_once __DIR__ . '/../classes/ProductImages.php';
require_once __DIR__ . '/../classes/Categories.php';

$products = new Products();
$productFilters = new ProductFilters();
$productSubcategories = new ProductSubcategories();
$productImages = new ProductImages();
$categories = new Categories();

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$description = $_POST['description'];
$quantity_weight = $_POST['quantity_weight'];
$price = $_POST['price'];
$category_id = $_POST['category_id'];
$filters = $_POST['filters'] ?? [];
$subcategories = $_POST['subcategories'] ?? [];
$image_urls = $_POST['image_urls'] ?? [];

// Vérifiez si le category_id existe dans la table categories
$category = $categories->getCategoryById($category_id);
if (!$category) {
    die('Erreur : Le category_id n\'existe pas.');
}

// Mettre à jour les détails du produit
$products->updateProduct($product_id, $product_name, $description, $quantity_weight, $price, $category_id);

// Mettre à jour les filtres
$productFilters->removeAllFiltersFromProduct($product_id);
foreach ($filters as $filter_id) {
    $productFilters->addFilterToProduct($product_id, $filter_id);
}

// Mettre à jour les sous-catégories
$productSubcategories->removeProductFromAllSubcategories($product_id);
foreach ($subcategories as $subcategories_id) {
    $productSubcategories->addProductToSubcategory($product_id, $subcategories_id);
}

// Mettre à jour les images
$productImages->removeAllImagesFromProduct($product_id);
foreach ($image_urls as $url) {
    // Vérifiez si l'image existe déjà dans la table images
    $existingImage = $productImages->getImageByUrl($url);
    if ($existingImage) {
        $image_id = $existingImage['image_id'];
    } else {
        $image_id = $productImages->addImage($url);
    }
    // Vérifiez si la relation entre le produit et l'image existe déjà
    if (!$productImages->isImageAlreadyLinkedToProduct($product_id, $image_id)) {
        $productImages->addImageToProduct($product_id, $image_id);
    }
}

header('Location: ../pages/manageProduct.php');
?>
