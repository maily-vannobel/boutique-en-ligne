<?php
require_once '../classes/Database.php';
require_once '../classes/Subcategories.php';
require_once '../classes/Products.php';

echo "Étape 1: Fichiers inclus.<br>";

$subcategories = new Subcategories();
$products = new Products();

$subcat_id = $_GET['subcat_id'] ?? null;

if ($subcat_id) {
    echo "Étape 2: ID de sous-catégorie reçu: $subcat_id<br>";
    $subcat_details = $subcategories->getSubcategoryById($subcat_id);
    $products_in_subcat = $products->getProductsBySubcategoryId($subcat_id);
    echo "Étape 3: Produits récupérés.<br>";
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
                <?= htmlspecialchars($product['product_name']) ?> - <?= htmlspecialchars($product['price']) ?> €
            </li>
        <?php endforeach; ?>
    </ul>
</main>
</body>
</html>
