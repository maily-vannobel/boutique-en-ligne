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

$category_id = $_GET['category_id'] ?? null;
$subcat_id = $_GET['subcat_id'] ?? null;

$products_in_subcat = [];

if ($subcat_id) {
    $subcat_details = $subcategories->getSubcategoryById($subcat_id);
    $products_in_subcat = $products->getProductsBySubcategoryId($subcat_id);
} elseif ($category_id) {
    $subcat_details = ['subcategories_name' => 'Toutes les sous-catégories de la catégorie'];
    $subcategoriesList = $subcategories->getSubcategoriesByCategoryId($category_id);

    foreach ($subcategoriesList as $subcategory) {
        $subcatProducts = $products->getProductsBySubcategoryId($subcategory['subcategories_id']);
        $products_in_subcat = array_merge($products_in_subcat, $subcatProducts);
    }
} else {
    $subcat_details = ['subcategories_name' => 'Toutes les catégories'];
    $products_in_subcat = $products->getAllProducts();
}

$all_filters = $filters->getAllFilters();

// Grouper les filtres par type
$grouped_filters = [];
foreach ($all_filters as $filter) {
    $grouped_filters[$filter['filter_type']][] = $filter;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <?php foreach ($grouped_filters as $filter_type => $filters): ?>
            <div class="mb-4">
                <button class="w-full text-left font-bold" onclick="toggleFilter('<?= htmlspecialchars($filter_type) ?>')"><?= htmlspecialchars(ucfirst($filter_type)) ?></button>
                <div id="<?= htmlspecialchars($filter_type) ?>" class="hidden">
                    <?php foreach ($filters as $filter): ?>
                        <div>
                            <input type="checkbox" class="filter-checkbox" name="<?= htmlspecialchars($filter['filter_type']) ?>" value="<?= htmlspecialchars($filter['filter_value']) ?>"> <?= htmlspecialchars($filter['filter_value']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </aside>

    <!-- Produits -->
    <div class="w-3/4 p-4">
        <h1 class="text-2xl font-bold mb-4"> <?= htmlspecialchars($subcat_details['subcategories_name']) ?></h1>
        <div id="product-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php foreach ($products_in_subcat as $product): ?>
                <div class="border p-4 rounded shadow">
                    <?php 
                    $product_images = $images->getImagesByProductId($product['product_id']); 
                    if (!empty($product_images)): 
                        $first_image = $product_images[0];
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

                    <form method="post" action="addToCart.php">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>">
                        <input type="hidden" name="product_price" value="<?= htmlspecialchars($product['price']) ?>">
                        <input type="number" name="product_quantity" value="1" min="1" class="w-16 p-1 border rounded">
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-2 flex items-center hover:bg-green-600">
                            <i class="fas fa-shopping-cart w-6 h-6 mr-2"></i>
                            Ajouter au panier
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<script src="/javascript/filter.js"></script>
</body>
</html>
