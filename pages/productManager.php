<?php
require_once __DIR__ . '/../classes/Subcategories.php';
require_once __DIR__ . '/../classes/Filters.php';

// Instanciation des classes
$subcategories = new Subcategories();
$filters = new Filters();

// Récupération des sous-catégories et des filtres
$allSubcategories = $subcategories->getAllSubcategories();
$allFilters = $filters->getAllFilters();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TableauAdmin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script defer src="../javascript/productManager.js"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <?php include '../includes/header.php'; ?>

    <div class="container mx-auto p-8">
        <div class="flex flex-wrap justify-center">
            <div class="w-full lg:w-1/2">
                <div class="leading-loose">
                    <form id="addProductForm" method="POST" action="../api/addProduct.php" class="max-w-xl m-4 p-10 bg-white rounded shadow-xl">
                        <p class="text-gray-800 font-medium text-center">Ajouter un Produit</p>
                        
                        <!-- Nom du Produit -->
                        <div>
                            <label class="block text-sm text-gray-600" for="product_name">Nom du Produit:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="product_name" name="product_name" required>
                        </div>

                        <!-- Description -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="description">Description:</label>
                            <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" id="description" name="description" required></textarea>
                        </div>

                        <!-- Quantité/Poids -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="quantity_weight">Quantité/Poids:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="quantity_weight" name="quantity_weight" required>
                        </div>

                        <!-- Prix -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="price">Prix:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="price" name="price" required>
                        </div>

                        <!-- Sous-catégorie -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="subcategories_id">Sous-catégorie:</label>
                            <select class="w-full px-4 py-2 text-gray-700 bg-gray-200 rounded" id="subcategories_id" name="subcategories_id" required>
                                <?php foreach ($allSubcategories as $subcategory): ?>
                                    <option value="<?= $subcategory['subcategories_id'] ?>"><?= $subcategory['subcategories_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- URLs des Images -->
                        <div class="mt-2" id="image_urls_container">
                            <label class="block text-sm text-gray-600" for="image_urls">URLs des Images:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" name="image_urls[]" required>
                            <button type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-gray-600" onclick="addImageUrlField()">Ajouter une URL d'image</button>
                            <button type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-red-500 rounded hover:bg-red-700" onclick="removeImageUrlField()">Supprimer la dernière URL</button>
                        </div>

                        <!-- Filtres -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="filters">Filtres:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="filter" placeholder="Saisissez un filtre">
                            <div id="selected-filters" class="flex flex-wrap mt-2"></div>
                        </div>

                        <div id="messageContainer" class="text-center py-4"></div>
                        <div class="mt-4 flex justify-center">
                            <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-green-500 " type="submit">Ajouter le Produit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script id="allFilters" type="application/json"><?php echo json_encode($allFilters); ?></script>
    <script id="selectedFilters" type="application/json"><?php echo json_encode($selectedFilters ?? []); ?></script>
</body>
</html>
