<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['promo_code'])) {
    $promo_code = $_POST['promo_code'];
    // Valider et appliquer le code promo ici
    // Exemple : si le code promo est 'PROMO10', appliquer une réduction de 10%
    if ($promo_code == 'PROMO10') {
        $_SESSION['promo_code'] = $promo_code;
        $_SESSION['discount'] = 10; // 10% de réduction
    }
}

header("Location: /pages/cart.php");
exit();
?>
