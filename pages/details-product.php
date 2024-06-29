<?php
require_once '../classes/Database.php';
require_once '../classes/Products.php';
require_once '../classes/Images.php';
require_once '../classes/ProductFilters.php';

$products = new Products();
$images = new Images();
$productFilters = new ProductFilters();

$product_id = $_GET['product_id'] ?? null;

if ($product_id) {
    $product_details = $products->getProductById($product_id);
    $product_images = $images->getImagesByProductId($product_id);

    // Get filters associated with the product
    $product_filters = $productFilters->getFiltersByProductId($product_id);
    $filter_ids = array_column($product_filters, 'filter_id');

    // Log de débogage des filtres
    error_log('Product Filters: ' . print_r($product_filters, true));

    if ($filter_ids) {
        // Get products with the same filters
        $similar_products = $products->getProductsByFilters($filter_ids, $product_id);
        // Log de débogage des produits similaires
        error_log('Similar Products: ' . print_r($similar_products, true));

        // Randomly pick a few similar products (max 5)
        $similar_products = array_slice($similar_products, 0, 5);
    } else {
        $similar_products = [];
    }
} else {
    header('Location: /index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du produit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-bxPxqsrZwb2C0rAK4A8fbGkChFhxV7ZUn6ALuA1Jzp8w/Xi5GQ3DgQ+y5hA4Rlm4drs6s/UluMDJzTWzkDMdqg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="/css/detail-products.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars($product_details['product_name']) ?></h1>

    <div class="grid grid-cols-6 gap-4">
        <!-- Thumbnails -->
        <div class="col-span-1">
            <div class="product-detail-thumbnails flex flex-col gap-2">
                <?php foreach ($product_images as $index => $image): ?>
                    <img class="product-detail-thumbnail <?= $index === 0 ? 'product-detail-selected-thumbnail' : '' ?>" src="<?= htmlspecialchars($image['url']) ?>" alt="<?= htmlspecialchars($product_details['product_name']) ?>" onclick="showImage('<?= htmlspecialchars($image['url']) ?>', this)">
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Main Image -->
        <div class="col-span-2 flex justify-center items-center">
            <div class="product-detail-main-image p-4 ">
                <img id="product-detail-main-image" class="product-detail-image max-h-96 object-contain" src="<?= htmlspecialchars($product_images[0]['url']) ?>" alt="<?= htmlspecialchars($product_details['product_name']) ?>">
            </div>
        </div>

        <!-- Description -->
        <div class="col-span-3">
            <div class="product-detail-description">
                <p class="text-gray-700"><?= htmlspecialchars($product_details['description']) ?></p>
                <p class="text-green-500 font-bold">Prix : <?= htmlspecialchars($product_details['price']) ?> €</p>
                <p class="text-gray-500">Poids : <?= htmlspecialchars($product_details['quantity_weight']) ?></p>
            </div>
        </div>
    </div>

    <!-- Produits similaires -->
    <h2 class="text-xl font-bold mt-10 mb-4">Produits similaires</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($similar_products as $product): ?>
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
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script src="/javascript/details.js"></script>
</body>
</html>
