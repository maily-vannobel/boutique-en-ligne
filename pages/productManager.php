<?php 
require_once __DIR__ . '/../classes/Subcategories.php';
require_once __DIR__ . '/../classes/Filters.php';

$subcategories = new Subcategories();
$filters = new Filters();

$allFilters = $filters->getAllFilters();
$allSubcategories = $subcategories->getAllSubcategories();
?>

<!DOCTYPE html>
<html>
<head>
    <title>TableauAdmin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <script defer src="../javascript/productManager.js"></script>
</head>
<body>

    <?php include '../includes/header.php'; ?>

    <h1>Ajouter un Produit</h1>
    <form method="POST" action="../api/addProduct.php">
        <label for="product_name">Nom du Produit:</label>
        <input type="text" id="product_name" name="product_name" required><br><br>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>
        
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required><br><br>
        
        <label for="ingredients">Ingrédients:</label>
        <textarea id="ingredients" name="ingredients" required></textarea><br><br>
        
        <label for="quantity_weight">Quantité/Poids:</label>
        <input type="text" id="quantity_weight" name="quantity_weight" required><br><br>
        
        <label for="price">Prix:</label>
        <input type="text" id="price" name="price" required><br><br>
        
        <label for="subcategories_id">Sous-catégorie:</label>
        <select id="subcategories_id" name="subcategories_id" required>
            <?php foreach ($allSubcategories as $subcategory): ?>
                <option value="<?= $subcategory['subcategories_id'] ?>"><?= $subcategory['subcategories_name'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="image_urls">URLs des Images:</label>
        <div id="image_urls_container">
            <input type="text" name="image_urls[]" required><br>
        </div>
        <button type="button" onclick="addImageUrlField()">Ajouter une URL d'image</button><br><br>

        <label for="filters">Filtres:</label>
        <select id="filters" name="filters[]" multiple required>
            <?php foreach ($allFilters as $filter): ?>
                <option value="<?= $filter['filter_id'] ?>"><?= $filter['filter_type'] ?>: <?= $filter['filter_value'] ?></option>
            <?php endforeach; ?>
        </select><br><br>
        
        <input type="submit" value="Ajouter le Produit">
    </form>
</body>
</html>
