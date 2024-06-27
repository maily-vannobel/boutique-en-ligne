<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: /pages/login.php");
    exit();
}

// Récupérez les articles du panier
$cart_items = $_SESSION['cart'] ?? [];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Pup Shop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <?php require_once '../includes/header.php';?>

    <main class="max-w-3xl mx-auto mt-10">
        <h1 class="text-3xl font-bold text-gray-900">Mon Panier</h1>
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h2 class="text-xl font-semibold text-gray-800">Articles dans le panier</h2>
            <?php if (empty($cart_items)): ?>
                <p>Votre panier est actuellement vide.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($cart_items as $item): ?>
                        <li class="flex justify-between items-center border-b py-2">
                            <span class="font-bold"><?= htmlspecialchars($item['name']) ?></span>
                            <span><?= htmlspecialchars($item['quantity']) ?> x <?= htmlspecialchars($item['price']) ?> €</span>
                            <span><?= htmlspecialchars($item['quantity'] * $item['price']) ?> €</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="mt-4">
                    <strong>Total :</strong> 
                    <?php 
                    $total = 0;
                    foreach ($cart_items as $item) {
                        $total += $item['quantity'] * $item['price'];
                    }
                    echo htmlspecialchars($total) . ' €';
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
