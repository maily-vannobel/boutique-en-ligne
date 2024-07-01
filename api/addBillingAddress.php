<?php
require_once '../classes/Database.php';
require_once '../classes/Address.php';
require_once '../classes/Users.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        http_response_code(403);
        echo json_encode(["message" => "Unauthorized"]);
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $billing_address = $_POST['billing_address'];
    $postal_code = $_POST['postal_code'];
    $city = $_POST['city'];

    try {
        $db = new Database();
        $address = new Address($db);

        $address->addBillingAddress($user_id, $billing_address, $postal_code, $city);

        $_SESSION['message'] = 'Adresse de facturation ajoutée avec succès!';
        header('Location: ../pages/profile.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = 'Erreur : ' . $e->getMessage();
        header('Location: ../pages/profile.php');
        exit();
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
}
?>
