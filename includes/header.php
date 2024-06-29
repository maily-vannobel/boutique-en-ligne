<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../classes/Categories.php';
require_once __DIR__ . '/../classes/Subcategories.php';

$categories = new Categories();
$allCategories = $categories->getAllCategories();
$subcategories = new Subcategories();

$isAdmin = isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1; // Assurez-vous que role_id est 1 pour l'admin
$isLoggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pup Shop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-white dark:bg-gray-900 shadow-md">
    <div class="max-w-screen-xl mx-auto p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Bienvenue sur Pup Shop</h1>
        <div class="md:hidden">
            <button id="burger-menu-button" class="text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <nav id="navbar" class="hidden md:flex space-x-4">
            <a href="/index.php" class="text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">Accueil</a>
            <div class="relative">
                <button id="profileIcon" data-dropdown-toggle="profileMenu" class="text-gray-800 dark:text-white hover:text-yellow-500 dark:hover:text-yellow-500 focus:outline-none" type="button">
                    <!-- SVG pour l'icône de profil -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M12 2a7 7 0 00-7 7v.605a8.006 8.006 0 0114 0V9a7 7 0 00-7-7zM4.21 12.947a8.037 8.037 0 01.268-.85C5.254 9.69 7.329 8 10 8h4c2.67 0 4.746 1.69 5.522 4.098.087.284.166.57.236.85C21.09 14.588 22 16.393 22 18.5a1.5 1.5 0 01-3 0 5.5 5.5 0 00-11 0 1.5 1.5 0 01-3 0c0-2.107.91-3.912 2.21-5.553z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div id="profileMenu" class="dropdown hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg dark:border-gray-700 dark:bg-gray-700">
                    <a href="<?= $isLoggedIn ? '/pages/profile.php' : '/pages/loginRegister.php' ?>" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Profil</a>
                    <?php if ($isLoggedIn): ?>
                        <a href="/api/logout.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Déconnexion</a>
                    <?php endif; ?>
                </div>
            </div>
            <a href="/pages/cart.php" class="text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">
                <!-- SVG pour l'icône du panier -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M3 3h2l.4 2M7 13h10l1.25-5H6.25L7 13zM7 13L5.3 4H20M16 16a1 1 0 11-2 0 1 1 0 012 0zM10 16a1 1 0 11-2 0 1 1 0 012 0z" />
                </svg>
            </a>
            <?php if ($isLoggedIn && $isAdmin): ?>
                <div class="relative">
                    <button id="adminMenuButton" class="text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500 px-3 py-2 rounded-md text-sm font-medium">Admin</button>
                    <div id="adminMenu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg dark:border-gray-700 dark:bg-gray-700">
                        <a href="/pages/addProductForm.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Ajouter un produit</a>
                        <a href="/pages/productManager.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Gérer les produits</a>
                        <a href="/pages/userManager.php" class="block px-4 py-2 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">Gérer les utilisateurs</a>
                    </div>
                </div>
            <?php endif; ?>
        </nav>
    </div>
</header>

<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-screen-xl mx-auto p-4 flex justify-between items-center">
        <div id="mega-menu" class="w-full md:flex md:justify-between">
            <ul class="flex flex-col md:flex-row md:space-x-8 space-y-4 md:space-y-0">
                <?php if (!empty($allCategories)): ?>
                    <?php foreach ($allCategories as $category): ?>
                        <li class="relative group">
                            <button id="mega-menu-dropdown-button-<?= $category['category_id'] ?>" data-dropdown-toggle="mega-menu-dropdown-<?= $category['category_id'] ?>" class="flex items-center justify-between w-full py-2 px-3 font-medium text-gray-900 dark:text-white border-b border-gray-100 md:border-0 hover:bg-gray-50 md:hover:bg-transparent dark:hover:bg-gray-700 md:hover:text-yellow-500 md:dark:hover:text-yellow-500">
                                <?= htmlspecialchars($category['category_name']) ?>
                                <svg class="w-2.5 h-2.5 ms-3 transition-transform transform group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6" aria-hidden="true">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <div id="mega-menu-dropdown-<?= $category['category_id'] ?>" class="dropdown hidden absolute z-10 w-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 text-sm bg-white border border-gray-100 rounded-lg shadow-md dark:border-gray-700 dark:bg-gray-700">
                                <div class="p-4 pb-0 text-gray-900 dark:text-white">
                                    <ul class="space-y-4" aria-labelledby="mega-menu-dropdown-button-<?= $category['category_id'] ?>">
                                        <li>
                                            <a href="/pages/products.php?category_id=<?= $category['category_id'] ?>" class="text-gray-500 dark:text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-500">
                                                Tout voir
                                            </a>
                                        </li>
                                        <?php
                                        $allSubcategories = $subcategories->getSubcategoriesByCategoryId($category['category_id']);
                                        foreach ($allSubcategories as $subcategory): ?>
                                            <li>
                                                <a href="/pages/products.php?subcat_id=<?= $subcategory['subcategories_id'] ?>" class="text-gray-500 dark:text-gray-400 hover:text-yellow-500 dark:hover:text-yellow-500">
                                                    <?= htmlspecialchars($subcategory['subcategories_name']) ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li>Aucune catégorie disponible</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900">
    <nav class="space-y-4 p-4">
        <a href="/index.php" class="block text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">Accueil</a>
        <a href="<?= $isLoggedIn ? '/pages/profile.php' : '/pages/loginRegister.php' ?>" class="block text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path fill-rule="evenodd" d="M12 2a7 7 0 00-7 7v.605a8.006 8.006 0 0114 0V9a7 7 0 00-7-7zM4.21 12.947a8.037 8.037 0 01.268-.85C5.254 9.69 7.329 8 10 8h4c2.67 0 4.746 1.69 5.522 4.098.087.284.166.57.236.85C21.09 14.588 22 16.393 22 18.5a1.5 1.5 0 01-3 0 5.5 5.5 0 00-11 0 1.5 1.5 0 01-3 0c0-2.107.91-3.912 2.21-5.553z" clip-rule="evenodd" />
            </svg>
        </a>
        <a href="/pages/cart.php" class="block text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                <path d="M3 3h2l.4 2M7 13h10l1.25-5H6.25L7 13zM7 13L5.3 4H20M16 16a1 1 0 11-2 0 1 1 0 012 0zM10 16a1 1 0 11-2 0 1 1 0 012 0z" />
            </svg>
        </a>
        <?php if ($isLoggedIn): ?>
            <?php if ($isAdmin): ?>
                <a href="/pages/addProductForm.php" class="block text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">Ajouter un produit</a>
                <a href="/pages/productManager.php" class="block text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">Gérer les produits</a>
                <a href="/pages/userManager.php" class="block text-gray-700 dark:text-gray-300 hover:text-yellow-500 dark:hover:text-yellow-500">Gérer les utilisateurs</a>
            <?php endif; ?>
        <?php endif; ?>
    </nav>
</div>

<script src="/javascript/menu.js"></script>
</body>
</html>
