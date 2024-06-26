<?php
require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/Subcategories.php';

$categories = new Categories();
$allCategories = $categories->getAllCategories();
$subcategories = new Subcategories();
?>

<header>
    <h1>Bienvenue sur Pup Shop</h1>
    <nav>
        <a href="/index.php">Accueil</a>
        <a href="/pages/products.php">Boutique</a>
        <a href="/pages/register.php">Inscription</a>
        <a href="/pages/login.php">Connexion</a>
        <a href="/pages/productManager.php">ADMIN _ProductManager</a>
        <a href="/pages/addProductForm.php">ADMIN _addProduct</a>
    </nav>
</header>

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto p-4">
        <div id="mega-menu" class="items-center justify-between w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col mt-4 font-medium md:flex-row md:mt-0 md:space-x-8 rtl:space-x-reverse">
                <?php foreach ($allCategories as $category): ?>
                    <li>
                        <button id="mega-menu-dropdown-button-<?= $category['category_id'] ?>" data-dropdown-toggle="mega-menu-dropdown-<?= $category['category_id'] ?>" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 border-b border-gray-100 md:w-auto hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700">
                            <?= htmlspecialchars($category['category_name']) ?>
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div id="mega-menu-dropdown-<?= $category['category_id'] ?>" class="dropdown hidden absolute z-10 grid hidden w-auto grid-cols-2 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 md:grid-cols-3 dark:bg-gray-700">
                            <div class="p-4 pb-0 text-gray-900 md:pb-4 dark:text-white">
                                <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button-<?= $category['category_id'] ?>">
                                    <?php
                                    $allSubcategories = $subcategories->getSubcategoriesByCategoryId($category['category_id']);
                                    foreach ($allSubcategories as $subcategory): ?>
                                        <li>
                                            <a href="/pages/products.php?subcat_id=<?= $subcategory['subcategories_id'] ?>" class="text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-500">
                                                <?= htmlspecialchars($subcategory['subcategories_name']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<script src="../javascript/menu.js"></script>
