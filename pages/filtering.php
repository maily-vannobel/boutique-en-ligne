<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories, Sous-catégories et Filtres</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        header {
            z-index: 10;
            position: relative;
        }
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <?php include '../includes/header.php'; ?>
    
    <section class="bg-gray-100 p-6">
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-6">Gestion des Catégories, Sous-catégories et Filtres</h1>
        
        <!-- Ajouter une Catégorie -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="addCategoryMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Ajouter une Catégorie</h2>
            <form id="addCategoryForm" class="space-y-4" data-action="addCategory">
                <div>
                    <label for="category_name" class="block text-gray-700">Nom de la Catégorie</label>
                    <input type="text" id="category_name" name="category_name" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
                </div>
            </form>
        </div>

        <!-- Modifier une Catégorie -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="updateCategoryMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Modifier une Catégorie</h2>
            <form id="updateCategoryForm" class="space-y-4" data-action="updateCategory">
                <div>
                    <label for="update_category_id" class="block text-gray-700">Nom de la Catégorie</label>
                    <select id="update_category_id" name="category_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <label for="update_category_name" class="block text-gray-700">Nouveau Nom de la Catégorie</label>
                    <input type="text" id="update_category_name" name="category_name" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Modifier</button>
                </div>
            </form>
        </div>

        <!-- Supprimer une Catégorie -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="deleteCategoryMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Supprimer une Catégorie</h2>
            <form id="deleteCategoryForm" class="space-y-4" data-action="deleteCategory">
                <div>
                    <label for="delete_category_id" class="block text-gray-700">Nom de la Catégorie</label>
                    <select id="delete_category_id" name="category_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Supprimer</button>
                </div>
            </form>
        </div>

        <!-- Ajouter une Sous-catégorie -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="addSubcategoryMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Ajouter une Sous-catégorie</h2>
            <form id="addSubcategoryForm" class="space-y-4" data-action="addSubcategory">
                <div>
                    <label for="subcategories_name" class="block text-gray-700">Nom de la Sous-catégorie</label>
                    <input type="text" id="subcategories_name" name="subcategories_name" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label for="subcategory_category_id" class="block text-gray-700">Nom de la Catégorie</label>
                    <select id="subcategory_category_id" name="category_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
                </div>
            </form>
        </div>

        <!-- Modifier une Sous-catégorie -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="updateSubcategoryMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Modifier une Sous-catégorie</h2>
            <form id="updateSubcategoryForm" class="space-y-4" data-action="updateSubcategory">
                <div>
                    <label for="subcategories_id" class="block text-gray-700">Nom de la Sous-catégorie</label>
                    <select id="subcategories_id" name="subcategories_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <label for="update_subcategories_name" class="block text-gray-700">Nouveau Nom de la Sous-catégorie</label>
                    <input type="text" id="update_subcategories_name" name="subcategories_name" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label for="update_subcategory_category_id" class="block text-gray-700">Nom de la Catégorie</label>
                    <select id="update_subcategory_category_id" name="category_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Modifier</button>
                </div>
            </form>
        </div>

        <!-- Supprimer une Sous-catégorie -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="deleteSubcategoryMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Supprimer une Sous-catégorie</h2>
            <form id="deleteSubcategoryForm" class="space-y-4" data-action="deleteSubcategory">
                <div>
                    <label for="delete_subcategories_id" class="block text-gray-700">Nom de la Sous-catégorie</label>
                    <select id="delete_subcategories_id" name="subcategories_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Supprimer</button>
                </div>
            </form>
        </div>

        <!-- Ajouter un Filtre -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="addFilterMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Ajouter un Filtre</h2>
            <form id="addFilterForm" class="space-y-4" data-action="addFilter">
                <div>
                    <label for="filter_type" class="block text-gray-700">Type de Filtre</label>
                    <input type="text" id="filter_type" name="filter_type" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label for="filter_value" class="block text-gray-700">Valeur du Filtre</label>
                    <input type="text" id="filter_value" name="filter_value" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
                </div>
            </form>
        </div>

        <!-- Modifier un Filtre -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="updateFilterMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Modifier un Filtre</h2>
            <form id="updateFilterForm" class="space-y-4" data-action="updateFilter">
                <div>
                    <label for="filter_id" class="block text-gray-700">Type de Filtre</label>
                    <select id="filter_id" name="filter_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <label for="update_filter_type" class="block text-gray-700">Nouveau Type de Filtre</label>
                    <input type="text" id="update_filter_type" name="filter_type" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <label for="update_filter_value" class="block text-gray-700">Nouvelle Valeur du Filtre</label>
                    <input type="text" id="update_filter_value" name="filter_value" class="w-full p-2 border border-gray-300 rounded mt-1">
                </div>
                <div>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Modifier</button>
                </div>
            </form>
        </div>

        <!-- Supprimer un Filtre -->
        <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
            <div id="deleteFilterMessage" class="hidden p-4 rounded mb-6"></div>
            <h2 class="text-2xl font-bold mb-4">Supprimer un Filtre</h2>
            <form id="deleteFilterForm" class="space-y-4" data-action="deleteFilter">
                <div>
                    <label for="delete_filter_id" class="block text-gray-700">Type de Filtre</label>
                    <select id="delete_filter_id" name="filter_id" class="w-full p-2 border border-gray-300 rounded mt-1">
                        <!-- Options will be dynamically loaded -->
                    </select>
                </div>
                <div>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Supprimer</button>
                </div>
            </form>
        </div>
    </div>
    </section>
    <script src="../javascript/filtering.js"></script>
</body>
</html>