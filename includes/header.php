<?php
session_start();
require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/Subcategories.php';

$categories = new Categories();
$allCategories = $categories->getAllCategories();
$subcategories = new Subcategories();

$isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1; // Assurez-vous que role_id est 1 pour l'admin
?>

<header class="bg-white dark:bg-gray-900 shadow-md">
    <div class="max-w-screen-xl mx-auto p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bienvenue sur Pup Shop</h1>
        <div class="md:hidden">
            <button id="burger-menu-button" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <nav id="navbar" class="hidden md:flex space-x-4">
            <a href="/index.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Accueil</a>
            <a href="/pages/products.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Boutique</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/pages/profile.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Profil</a>
                <a href="/pages/logout.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Déconnexion</a>
                <a href="/pages/cart.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Panier</a>
                <?php if ($isAdmin): ?>
                    <div class="relative">
                        <button id="adminMenuButton" data-dropdown-toggle="adminMenu" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Admin</button>
                        <div id="adminMenu" class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg dark:border-gray-700 dark:bg-gray-700">
                            <a href="/pages/addProductForm.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Ajouter un produit</a>
                            <a href="/pages/productManager.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Gérer les produits</a>
                            <a href="/pages/userManager.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Gérer les utilisateurs</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <a href="/pages/register.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Inscription</a>
                <a href="/pages/login.php" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Connexion</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-screen-xl mx-auto p-4 flex justify-between items-center">
        <div id="mega-menu" class="w-full md:flex md:justify-between">
            <ul class="flex flex-col md:flex-row md:space-x-8 space-y-4 md:space-y-0">
                <?php foreach ($allCategories as $category): ?>
                    <li class="relative group">
                        <button id="mega-menu-dropdown-button-<?= $category['category_id'] ?>" data-dropdown-toggle="mega-menu-dropdown-<?= $category['category_id'] ?>" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 dark:text-white border-b border-gray-100 md:border-0 hover:bg-gray-50 md:hover:bg-transparent dark:hover:bg-gray-700 md:hover:text-blue-600 md:dark:hover:text-blue-500">
                            <?= htmlspecialchars($category['category_name']) ?>
                            <svg class="w-2.5 h-2.5 ms-3 transition-transform transform group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" aria-hidden="true">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div id="mega-menu-dropdown-<?= $category['category_id'] ?>" class="dropdown hidden absolute z-10 w-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-700 group-hover:block">
                            <div class="p-4 pb-0 text-gray-900 dark:text-white">
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

<div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900">
    <nav class="space-y-4 p-4">
        <a href="/index.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Accueil</a>
        <a href="/pages/products.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Boutique</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/pages/profile.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Profil</a>
            <a href="/pages/logout.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Déconnexion</a>
            <a href="/pages/cart.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Panier</a>
            <?php if ($isAdmin): ?>
                <div class="relative">
                    <button id="mobileAdminMenuButton" data-dropdown-toggle="mobileAdminMenu" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500 px-3 py-2 rounded-md text-sm font-medium">Admin</button>
                    <div id="mobileAdminMenu" class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg dark:border-gray-700 dark:bg-gray-700">
                        <a href="/pages/addProductForm.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Ajouter un produit</a>
                        <a href="/pages/productManager.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Gérer les produits</a>
                        <a href="/pages/userManager.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Gérer les utilisateurs</a>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <a href="/pages/register.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Inscription</a>
            <a href="/pages/login.php" class="block text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-500">Connexion</a>
        <?php endif; ?>
    </nav>
</div>

<script src="/javascript/menu.js"></script>
