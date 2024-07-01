<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../classes/Database.php';
require_once '../classes/Address.php';

if (!isset($_SESSION['user_id'])) {
    exit();
}

$address_id = $_POST['address_id'];
$deliveryAddress = $_POST['delivery_address'];
$addressComplement = $_POST['address_complement'];
$postalCode = $_POST['postal_code'];
$city = $_POST['city'];
$billingAddress = $_POST['billing_address'];

$db = new Database();
$address = new Address($db);

if ($address->updateAddress($address_id, $deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress)) {
    $_SESSION['message'] = "Adresse mise à jour avec succès.";
} else {
    $_SESSION['error'] = "Erreur lors de la mise à jour de l'adresse.";
}

header("Location: ../pages/profile.php");
exit();
?>
