<?php
require_once '../classes/Database.php';
require_once '../classes/Subcategories.php';
require_once '../classes/Products.php';
require_once '../classes/Images.php';
require_once '../classes/Filters.php';

$subcategories = new Subcategories();
$products = new Products();
$images = new Images();
$filters = new Filters();

$subcat_id = $_GET['subcat_id'] ?? null;

if ($subcat_id) {
    $subcat_details = $subcategories->getSubcategoryById($subcat_id);
    $products_in_subcat = $products->getProductsBySubcategoryId($subcat_id);
} else {
    $subcat_details = ['subcategories_name' => 'Toutes les catégories'];
    $products_in_subcat = $products->getAllProducts(); // Afficher tous les produits si aucun subcat_id
}

$all_filters = $filters->getAllFilters();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container mx-auto p-4 flex">
    <!-- Sidebar -->
    <aside class="w-1/4 p-4 border-r">
        <h2 class="text-xl font-bold mb-4">Filtres</h2>
        <!-- Couleurs -->
        <div class="mb-4">
            <button class="w-full text-left font-bold" onclick="toggleFilter('couleur')">Couleurs</button>
            <div id="couleur" class="hidden">
                <?php
                $colors = array_filter($all_filters, fn($filter) => $filter['filter_type'] === 'couleur');
                foreach ($colors as $color) {
                    echo '<div><input type="checkbox" class="filter-checkbox" name="couleur" value="' . htmlspecialchars($color['filter_value']) . '"> ' . htmlspecialchars($color['filter_value']) . '</div>';
                }
                ?>
            </div>
        </div>
        <!-- Ingrédients -->
        <div class="mb-4">
            <button class="w-full text-left font-bold" onclick="toggleFilter('ingredient')">Ingrédients</button>
            <div id="ingredient" class="hidden">
                <?php
                $ingredients = array_filter($all_filters, fn($filter) => $filter['filter_type'] === 'ingrédient');
                foreach ($ingredients as $ingredient) {
                    echo '<div><input type="checkbox" class="filter-checkbox" name="ingrédient" value="' . htmlspecialchars($ingredient['filter_value']) . '"> ' . htmlspecialchars($ingredient['filter_value']) . '</div>';
                }
                ?>
            </div>
        </div>
        <!-- Marques -->
        <div class="mb-4">
            <button class="w-full text-left font-bold" onclick="toggleFilter('marque')">Marques</button>
            <div id="marque" class="hidden">
                <?php
                $brands = array_filter($all_filters, fn($filter) => $filter['filter_type'] === 'marque');
                foreach ($brands as $brand) {
                    echo '<div><input type="checkbox" class="filter-checkbox" name="marque" value="' . htmlspecialchars($brand['filter_value']) . '"> ' . htmlspecialchars($brand['filter_value']) . '</div>';
                }
                ?>
            </div>
        </div>
    </aside>

    <!-- Produits -->
    <div class="w-3/4 p-4">
        <h1 class="text-2xl font-bold mb-4">Produits dans la catégorie <?= htmlspecialchars($subcat_details['subcategories_name']) ?></h1>
        <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($products_in_subcat as $product): ?>
                <div class="border p-4 rounded shadow">
                    <?php 
                    $product_images = $images->getImagesByProductId($product['product_id']); 
                    if (!empty($product_images)): 
                        $first_image = $product_images[0]; // Get the first image
                    ?>
                        <a href="/pages/details-product.php?product_id=<?= htmlspecialchars($product['product_id']) ?>">
                            <img class="product-image" src="<?= htmlspecialchars($first_image['url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                        </a>
                    <?php endif; ?>
                    <a href="/pages/details-product.php?product_id=<?= htmlspecialchars($product['product_id']) ?>" class="text-xl font-semibold">
                        <?= htmlspecialchars($product['product_name']) ?>
                    </a>
                    <p class="text-green-500 font-bold">Prix : <?= htmlspecialchars($product['price']) ?> €</p>
                    <p class="text-gray-500">Poids : <?= htmlspecialchars($product['quantity_weight']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script src="/javascript/filter.js"></script>
</body>
</html>