<?php
session_start(); // Démarrer la session

require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/Subcategories.php';
require_once __DIR__ . '/../classes/Filters.php';

$categories = new Categories();
$subcategories = new Subcategories();
$filters = new Filters();

$allCategories = $categories->getAllCategories();
$allSubcategories = $subcategories->getAllSubcategories();
$allFilters = $filters->getAllFilters();

$subcategoriesByCategory = [];
foreach ($allSubcategories as $subcategory) {
    $subcategoriesByCategory[$subcategory['category_id']][] = $subcategory;
}
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

                        <?php if (isset($_SESSION['success_message'])): ?>
                            <div class="bg-green-500 text-white text-center py-2 my-2 rounded">
                                <?php echo $_SESSION['success_message']; ?>
                            </div>
                            <?php unset($_SESSION['success_message']); ?>
                        <?php endif; ?>

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

                        <!-- URLs des Images -->
                        <div class="mt-2" id="image_urls_container">
                            <label class="block text-sm text-gray-600" for="image_urls">URLs des Images:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" name="image_urls[]" required>
                            <button style="width:100%;" type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-gray-600" onclick="addImageUrlField()">Ajouter une URL d'image</button>
                            <button style="width:100%;" type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-red-500 rounded hover:bg-red-700" onclick="removeImageUrlField()">Supprimer la dernière URL</button>
                        </div>

                       <!-- Sous-catégories -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="subcategories">Sous-catégories:</label>
                            <select class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="subcategory-select">
                                <option value="">Sélectionnez une sous-catégorie</option>
                                <?php foreach ($allCategories as $category) : ?>
                                    <optgroup label="<?php echo htmlspecialchars($category['category_name']); ?>">
                                        <?php if (isset($subcategoriesByCategory[$category['category_id']])) : ?>
                                            <?php foreach ($subcategoriesByCategory[$category['category_id']] as $subcategory) : ?>
                                                <option value="<?php echo htmlspecialchars($subcategory['subcategories_id']); ?>" data-category-id="<?php echo htmlspecialchars($subcategory['category_id']); ?>">
                                                    <?php echo htmlspecialchars($subcategory['subcategories_name']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </optgroup>
                                <?php endforeach; ?>
                            </select>
                            <button style="width:100%;" type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-gray-600" id="addSubcategoryButton">Ajouter une sous-catégorie</button>
                            <button style="width:100%;" type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-red-500 rounded hover:bg-red-700" id="removeSubcategoryButton">Supprimer la dernière sous-catégorie</button>
                            <div id="selected-subcategories" class="flex flex-wrap mt-2"></div>
                        </div>

                        <!-- Filtres -->
                        <div class="mt-2">
                            <label class="block text-sm text-gray-600" for="filters">Filtres:</label>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="filter" placeholder="Saisissez un filtre">
                            <div id="selected-filters" class="flex flex-wrap mt-2"></div>
                        </div>

                        <!-- Catégorie -->
                        <input type="hidden" id="category_id" name="category_id" value="">
                        
                        <div id="messageContainer" class="text-center py-4"></div>
                        <div class="mt-4 flex justify-center">
                            <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-green-500" type="submit">Ajouter le Produit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script id="allFilters" type="application/json"><?php echo json_encode($allFilters); ?></script>
    <script id="selectedFilters" type="application/json"><?php echo json_encode($selectedFilters ?? []); ?></script>
    <script src="../javascript/productManager.js"></script>
</body>
</html>