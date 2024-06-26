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
    <style>
        .product-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4"><?= htmlspecialchars($product_details['product_name']) ?></h1>
    <p class="text-gray-700"><?= htmlspecialchars($product_details['description']) ?></p>
    <p class="text-green-500 font-bold">Prix : <?= htmlspecialchars($product_details['price']) ?> €</p>
    <p class="text-gray-500">Poids : <?= htmlspecialchars($product_details['quantity_weight']) ?></p>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        <?php foreach ($product_images as $image): ?>
            <img class="product-image" src="<?= htmlspecialchars($image['url']) ?>" alt="<?= htmlspecialchars($product_details['product_name']) ?>">
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>
