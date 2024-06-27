<?php
require_once '../classes/Database.php';
require_once '../classes/Users.php';

session_start();

$message = '';

if (isset($_SESSION['register_success'])) {
    $message = $_SESSION['register_success'];
    unset($_SESSION['register_success']);
}

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
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role_id'] = $user['role_id'];
            header('Location: ../index.php');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Pup Shop</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body>
<?php include '../includes/header.php'; ?>

<main class="max-w-md mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-5">Connexion</h1>
    <?php if ($message): ?>
        <p class="text-green-500"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form action="login.php" method="post" class="space-y-6" onsubmit="return validateLoginForm()">
        <input type="hidden" id="login_method" name="login_method" value="email">
        <div id="email_login" class="relative z-0 w-full mb-5 group">
            <input type="email" name="identifier" id="identifier" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="identifier" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
        </div>
        <div id="phone_login" class="relative z-0 w-full mb-5 group" style="display: none;">
            <input type="text" name="phone_identifier" id="phone_identifier" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
            <label for="phone_identifier" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Téléphone</label>
        </div>
        <div class="relative z-0 w-full mb-5 group">
            <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
            <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mot de passe</label>
        </div>
        <div id="loginError" class="text-red-500 text-sm mt-2"></div>
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Se connecter</button>
    </form>

    <a href="#" id="toggleLoginMethod" class="text-blue-600 hover:underline">S'identifier avec son numéro de téléphone</a>
</main>
<script src="/javascript/login.js"></script>
</body>
</html>
