<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/Database.php';
require_once '../classes/Address.php';

if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];
$db = new Database();
$address = new Address($db);

$deliveryAddress = $_POST['delivery_address'];
$addressComplement = $_POST['address_complement'];
$postalCode = $_POST['postal_code'];
$city = $_POST['city'];
$billingAddress = $_POST['billing_address'];

if ($address->addAddress($user_id, $deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress)) {
    $_SESSION['message'] = "Adresse ajoutée avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de l'ajout de l'adresse.";
}

header("Location: ../pages/profile.php");
exit();
