<?php
require_once '../classes/Database.php';
require_once '../classes/Users.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $phone = $_POST['phone'];

    if ($password !== $confirm_password) {
        $message = 'Les mots de passe ne correspondent pas';
    } else if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/', $password)) {
        $message = 'Le mot de passe doit contenir au moins 8 caractères, un chiffre et un caractère spécial';
    } else {
        try {
            $users = new Users();
            $user_id = $users->create_user($last_name, $first_name, $email, $password, $phone);
            $message = "Utilisateur créé avec succès ! ID utilisateur : " . $user_id;
        } catch (Exception $e) {
            $message = 'Erreur : ' . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Pup Shop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body>
<?php require_once '../includes/header.php';?>

<main>
    <h1>Inscription</h1>
    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="register.php" method="post" onsubmit="return validateForm()">
        <label for="last_name">Nom:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="first_name">Prénom:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="confirm_password">Confirmer le mot de passe:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br><br>
        <div id="passwordError" class="error"></div>

        <label for="phone">Téléphone:</label>
        <input type="text" id="phone" name="phone" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>

    <script src="../javascript/register.js"></script>
</main>
</body>
</html>