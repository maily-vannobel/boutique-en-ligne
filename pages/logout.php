<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire complètement la session> aussi effacer le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session.
session_destroy();

header("Location: /pages/login.php");
exit;
