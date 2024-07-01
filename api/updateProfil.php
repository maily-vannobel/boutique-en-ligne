<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../classes/Users.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php'); 
    exit();
}

$user_id = $_SESSION['user_id'];
$users = new Users();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    try {
        $users->update_user($user_id, $last_name, $first_name, $email, $phone, $password);
        $_SESSION['message'] = "Profil mis à jour avec succès";
        header('Location: ../pages/profile.php'); 
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour du profil: " . $e->getMessage();
        header('Location: ../pages/profile.php');
        exit();
    }
}
?>
