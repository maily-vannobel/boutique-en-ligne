<?php
require_once '../classes/Database.php';
require_once '../classes/Subcategories.php';
require_once '../classes/Products.php';

$subcategories = new Subcategories();
$products = new Products();

$subcat_id = $_GET['subcat_id'] ?? null;

if ($subcat_id) {
    $subcat_details = $subcategories->getSubcategoryById($subcat_id);
    $products_in_subcat = $products->getProductsBySubcategoryId($subcat_id);
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
    <title>Boutique</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main>
    <h1>Produits dans la catégorie <?= htmlspecialchars($subcat_details['subcategories_name']) ?></h1>
    <ul>
        <?php foreach ($products_in_subcat as $product): ?>
            <li>
                <h2><?= htmlspecialchars($product['product_name']) ?></h2>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p>Prix : <?= htmlspecialchars($product['price']) ?> €</p>
                <p>Poids : <?= htmlspecialchars($product['quantity_weight']) ?></p>

                <?php 
                $product_images = $products->getProductImages($product['product_id']);
                if (!empty($product_images)): ?>
                    <div class="product-images">
                        <?php foreach ($product_images as $image): ?>
                            <img src="<?= htmlspecialchars($image['url']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>
</body>
</html>
