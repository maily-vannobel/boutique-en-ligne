<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Users.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'login') {
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

            if ($user) {
                if (password_verify($password, $user['password'])) {
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
            } else {
                $message = 'Utilisateur non trouvé';
            }
        } catch (Exception $e) {
            $message = 'Erreur : ' . $e->getMessage();
        }
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'register') {
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $phone = $_POST['phone'];

        if ($password !== $confirm_password) {
            $message = 'Les mots de passe ne correspondent pas';
        } else {
            try {
                $users = new Users();
                $user_id = $users->create_user($last_name, $first_name, $email, $password, $phone);
                $_SESSION['register_success'] = 'Félicitations, votre compte a été créé! ';
                header('Location: loginRegister.php');
                exit();
            } catch (Exception $e) {
                $message = 'Erreur : ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejoignez Pup Shop !</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body>
<?php require_once '../includes/header.php'; ?>

<main class="max-w-md mx-auto mt-10">
    <div class="border-b border-gray-300">
        <ul class="flex cursor-pointer">
            <li class="mr-1">
                <button id="register-tab" class="inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" onclick="showRegister()">Créer un compte</button>
            </li>
            <li class="mr-1">
                <button id="login-tab" class="inline-block py-2 px-4 text-gray-500 hover:text-blue-800 font-semibold" onclick="showLogin()">Connexion</button>
            </li>
        </ul>
    </div>
    
    <!-- Formulaire d'inscription -->
    <div id="register-form" style="display: none;">
        <h1 class="text-2xl font-bold mb-5">Inscription</h1>
        <?php if ($message && isset($_POST['form_type']) && $_POST['form_type'] == 'register'): ?>
            <p class="text-red-500"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="loginRegister.php" method="post" class="space-y-6" onsubmit="return validateForm()">
            <input type="hidden" name="form_type" value="register">

            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="last_name" id="last_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="last_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Nom</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="first_name" id="first_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="first_name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Prénom</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="email" name="email" id="email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="password" id="password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mot de passe</label>
                <p id="passwordError" class="text-red-500 text-sm mt-2"></p>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="password" name="confirm_password" id="confirm_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="confirm_password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirmer le mot de passe</label>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <input type="text" name="phone" id="phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                <label for="phone" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Téléphone</label>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">S'inscrire</button>
        </form>
    </div>

    <!-- Formulaire de connexion -->
    <div id="login-form">
        <h1 class="text-2xl font-bold mb-5">Connexion</h1>
        <?php if ($message && isset($_POST['form_type']) && $_POST['form_type'] == 'login'): ?>
            <p class="text-red-500"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="loginRegister.php" method="post" class="space-y-6">
            <input type="hidden" name="form_type" value="login">
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
    </div>
</main>
<script src="/javascript/loginRegister.js"></script>
</body>
</html>
