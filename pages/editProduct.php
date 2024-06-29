<?php
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/ProductFilters.php';
require_once __DIR__ . '/../classes/ProductSubcategories.php';
require_once __DIR__ . '/../classes/ProductImages.php';
require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/Subcategories.php';
require_once __DIR__ . '/../classes/Filters.php';

$products = new Products();
$productFilters = new ProductFilters();
$productSubcategories = new ProductSubcategories();
$productImages = new ProductImages();
$categories = new Categories();
$subcategories = new Subcategories();
$filters = new Filters();

$product_id = isset($_GET['id']) ? $_GET['id'] : '';
$product = $products->getProductById($product_id);

if (!$product) {
    die('Erreur : Produit non trouvé.');
}

$productFiltersList = $productFilters->getFiltersByProductId($product_id);
$productSubcategoriesList = $productSubcategories->getSubcategoriesByProductId($product_id);
$productImagesList = $productImages->getImagesByProductId($product_id);

$allFilters = $filters->getAllFilters();
$allSubcategories = $subcategories->getAllSubcategories(); 
$allCategories = $categories->getAllCategories();

$subcategoriesByCategory = [];
foreach ($allSubcategories as $subcategory) {
    $subcategoriesByCategory[$subcategory['category_id']][] = $subcategory;
}

$selectedFilters = [];
foreach ($productFiltersList as $filter) {
    $selectedFilters[] = [
        'id' => $filter['filter_id'],
        'value' => $filter['filter_value'],
        'type' => $filter['filter_type']
    ];
}

$selectedSubcategories = [];
foreach ($productSubcategoriesList as $subcategory) {
    $selectedSubcategories[] = [
        'id' => $subcategory['subcategories_id'],
        'name' => $subcategory['subcategories_name']
    ];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Produit</title>
    <link rel="stylesheet" href="../css/editProduct.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="container mx-auto p-8">
    <div class="back-button" onclick="history.back()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </div>
    <div class="flex flex-wrap justify-center">
        <div class="w-full lg:w-1/2">
            <div class="leading-loose">
                <form id="editProductForm" method="POST" action="../api/updateProduct.php" class="max-w-xl m-4 p-10 bg-white rounded shadow-xl">
                    <p class="text-gray-800 font-medium text-center">Modifier le Produit</p>

                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

                    <div>
                        <label class="block text-sm text-gray-600" for="product_name">Nom du Produit:</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="description">Description:</label>
                        <textarea class="w-full px-5 py-2 text-gray-700 bg-gray-200 rounded" id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="quantity_weight">Quantité/Poids:</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="quantity_weight" name="quantity_weight" value="<?php echo htmlspecialchars($product['quantity_weight']); ?>" required>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="price">Prix:</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="category_id">Catégorie:</label>
                        <select class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" id="category_id" name="category_id" required>
                            <?php foreach ($allCategories as $category) : ?>
                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>" <?php if ($category['category_id'] == $product['category_id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mt-2" id="image_urls_container">
                        <label class="block text-sm text-gray-600" for="image_urls">URLs des Images:</label>
                        <?php if (empty($productImagesList)): ?>
                            <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded mb-2" type="text" name="image_urls[]">
                        <?php else: ?>
                            <?php foreach ($productImagesList as $image): ?>
                                <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded mb-2" type="text" name="image_urls[]" value="<?php echo htmlspecialchars($image['url']); ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <button style="width:100%;" type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-gray-600" id="addImageUrlButton">Ajouter une URL d'image</button>
                        <button style="width:100%;" type="button" class="mt-2 px-4 py-1 text-white font-light tracking-wider bg-red-500 rounded hover:bg-red-700" id="removeImageUrlButton">Supprimer la dernière URL</button>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="subcategory-select">Sous-catégories:</label>
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
                        <div id="selected-subcategories" class="flex flex-wrap mt-2">
                            <?php foreach ($selectedSubcategories as $subcategory) : ?>
                                <div class="subcategory bg-gray-200 rounded px-2 py-1 m-1 flex items-center" data-id="<?php echo htmlspecialchars($subcategory['id']); ?>">
                                    <span><?php echo htmlspecialchars($subcategory['name']); ?></span>
                                    <button type="button" class="ml-2 text-red-500 remove-subcategory">✖</button>
                                    <input type="hidden" name="subcategories[]" value="<?php echo htmlspecialchars($subcategory['id']); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mt-2">
                        <label class="block text-sm text-gray-600" for="filter">Filtres:</label>
                        <input class="w-full px-5 py-1 text-gray-700 bg-gray-200 rounded" type="text" id="filter" placeholder="Saisissez un filtre">
                        <div id="selected-filters" class="flex flex-wrap mt-2">
                            <?php foreach ($selectedFilters as $filter) : ?>
                                <div class="filter bg-gray-200 rounded px-2 py-1 m-1 flex items-center" data-id="<?php echo htmlspecialchars($filter['id']); ?>">
                                    <span><?php echo htmlspecialchars($filter['type']); ?>: <?php echo htmlspecialchars($filter['value']); ?></span>
                                    <button type="button" class="ml-2 text-red-500 remove-filter">✖</button>
                                    <input type="hidden" name="filters[]" value="<?php echo htmlspecialchars($filter['id']); ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-center">
                        <button class="px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded hover:bg-green-500" type="submit">Mettre à jour le produit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const selectedFilters = <?php echo json_encode($selectedFilters); ?>;
    const selectedSubcategories = <?php echo json_encode($selectedSubcategories); ?>;
    const allFilters = <?php echo json_encode($allFilters); ?>;
</script>
<script src="../javascript/editProductForm.js"></script>
</body>
</html>

