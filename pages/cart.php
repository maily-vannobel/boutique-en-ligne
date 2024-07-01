<?php
require_once '../classes/Database.php';
require_once '../classes/Users.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: loginRegister.php');
    exit();
}

require_once '../includes/header.php';

$cart_items = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <main class="max-w-6xl mx-auto mt-10">
        <h1 class="text-3xl font-bold text-gray-900">Mon Panier</h1>
        <div class="flex">
            <!-- Section du panier -->
            <div class="w-2/3 bg-white p-6 rounded-lg shadow-md mt-6 mr-6">
                <h2 class="text-xl font-semibold text-gray-800">Articles dans le panier</h2>
                <?php if (empty($cart_items)): ?>
                    <p>Votre panier est actuellement vide.</p>
                <?php else: ?>
                    <ul>
                        <?php foreach ($cart_items as $product_id => $item): ?>
                            <li class="flex justify-between items-center border-b py-2">
                                <span class="font-bold"><?= htmlspecialchars($item['name'] ?? 'Nom indisponible') ?></span>
                                <span>
                                    <form method="post" action="/api/updateCart.php" class="inline">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                                        <input type="number" name="quantity" value="<?= htmlspecialchars($item['quantity'] ?? 1) ?>" min="1" class="w-16 p-1 border rounded">
                                        <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded">Mettre à jour</button>
                                    </form>
                                </span>
                                <span><?= htmlspecialchars($item['price'] ?? '0.00') ?> €</span>
                                <span><?= htmlspecialchars(($item['quantity'] ?? 0) * ($item['price'] ?? 0)) ?> €</span>
                                <form method="post" action="/api/removeFromCart.php" class="inline">
                                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Supprimer</button>
                                </form>                       
                             </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-4">
                        <strong>Total :</strong> 
                        <?php 
                        $total = 0;
                        foreach ($cart_items as $item) {
                            $total += ($item['quantity'] ?? 0) * ($item['price'] ?? 0);
                        }
                        echo htmlspecialchars($total) . ' €';
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Section du code promo et validation -->
            <div class="w-1/3 bg-white p-6 rounded-lg shadow-md mt-6">
                <h2 class="text-xl font-semibold text-gray-800">Code Promo</h2>
                <form method="post" action="/api/applyPromoCode.php">
                    <div class="mb-4">
                        <input type="text" name="promo_code" placeholder="Entrez votre code promo" class="w-full p-2 border rounded">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Appliquer</button>
                </form>

                <div class="mt-6">
                    <button onclick="window.location.href='/api/checkout.php'" class="bg-green-500 text-white px-4 py-2 rounded w-full">Valider la commande</button>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
