<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: /pages/loginRegister.php');
    exit();
}

$cart_items = $_SESSION['cart'] ?? [];
$total = 0;

foreach ($cart_items as $item) {
    $total += ($item['quantity'] ?? 0) * ($item['price'] ?? 0);
}

// Appliquer la réduction si un code promo est valide
if (isset($_SESSION['discount'])) {
    $discount = $_SESSION['discount'];
    $total = $total - ($total * ($discount / 100));
}

// Traitez la commande et sauvegardez les détails dans la base de données
// ...

// Vider le panier après la validation
unset($_SESSION['cart']);
unset($_SESSION['promo_code']);
unset($_SESSION['discount']);

header("Location: /pages/confirmation.php");
exit();
?>
