<?php
require_once '../classes/Database.php';
require_once '../classes/Products.php';
require_once '../classes/Images.php';

$products = new Products();
$images = new Images();

$product_id = $_GET['product_id'] ?? null;

if ($product_id) {
    $product_details = $products->getProductById($product_id);
    $product_images = $images->getImagesByProductId($product_id);
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
</main>

<script src="/javascript/details.js"></script>
</body>
</html>
