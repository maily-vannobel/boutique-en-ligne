<?php
require_once '../classes/Database.php';
require_once '../classes/Users.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_method = $_POST['login_method'];
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    try {
        $users = new Users();
        if ($login_method === 'email') {
            $user = $users->get_user_by_email($identifier);
        } else {
            $user = $users->get_user_by_phone($identifier);
        }

        if ($user && password_verify($password, $user['password'])) {
            // L'utilisateur est authentifié
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role_id'] = $user['role_id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $message = 'Identifiant ou mot de passe incorrect';
        }
    } catch (Exception $e) {
        $message = 'Erreur : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Connexion</h1>
    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="login.php" method="post" onsubmit="return validateLoginForm()">
        <input type="hidden" id="login_method" name="login_method" value="email">
        <div id="email_login">
            <label for="identifier">Email:</label>
            <input type="email" id="identifier" name="identifier" required><br><br>
        </div>
        <div id="phone_login" style="display: none;">
            <label for="phone_identifier">Téléphone:</label>
            <input type="text" id="phone_identifier" name="identifier"><br><br>
        </div>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>
        <div id="loginError" class="error"></div>

        <input type="submit" value="Se connecter">
    </form>

    <a href="#" id="toggleLoginMethod">S'identifier avec son numéro de téléphone</a>

    <script src="javascript/login.js"></script>
</body>
</html>
