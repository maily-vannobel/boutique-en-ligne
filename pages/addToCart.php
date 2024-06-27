<?php
session_start();

// Vérifiez si les données du produit sont envoyées
if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_quantity'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];

    // Créez une structure de panier si elle n'existe pas déjà
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Vérifiez si l'article est déjà dans le panier
    if (isset($_SESSION['cart'][$product_id])) {
        // Si l'article est déjà dans le panier, augmentez la quantité
        $_SESSION['cart'][$product_id]['quantity'] += $product_quantity;
    } else {
        // Ajoutez le nouvel article au panier
        $_SESSION['cart'][$product_id] = [
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => $product_quantity
        ];
    }
}

// Redirigez vers la page de la boutique ou une autre page appropriée
header("Location: /pages/products.php");
exit();
