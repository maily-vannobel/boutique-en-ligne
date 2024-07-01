<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../classes/Database.php';
require_once '../classes/Users.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour effectuer cette action.";
    header('Location: ../pages/profile.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Les nouveaux mots de passe ne correspondent pas.";
        header('Location: ../pages/profile.php');
        exit();
    }

    $users = new Users();
    $user = $users->get_user_by_id($user_id);

    if (!password_verify($old_password, $user['password'])) {
        $_SESSION['error'] = "L'ancien mot de passe est incorrect.";
        header('Location: ../pages/profile.php');
        exit();
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    if ($users->update_user_password($user_id, $hashed_password)) {
        $_SESSION['message'] = "Mot de passe mis à jour avec succès.";
    } else {
        $_SESSION['error'] = "Erreur lors de la mise à jour du mot de passe.";
    }

    header('Location: ../pages/profile.php');
    exit();
}
?>
