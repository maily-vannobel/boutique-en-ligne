<?php
require_once '../includes/header.php'; // Assurez-vous que session_start() est dans le header

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

header("Location: /pages/cart.php");
exit();
?>
