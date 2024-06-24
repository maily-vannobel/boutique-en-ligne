<?php
require_once '../classes/Database.php';
require_once '../classes/Users.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    try {
        $users = new Users();
        $user_id = $users->create_user($last_name, $first_name, $email, $password, $phone);
        $message = "Utilisateur créé avec succès ! ID utilisateur : " . $user_id;
    } catch (Exception $e) {
        $message = 'Erreur : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>
    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="phone">Téléphone:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
