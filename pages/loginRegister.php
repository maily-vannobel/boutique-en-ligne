<?php 
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Users.php';
require_once __DIR__ . '/../classes/Address.php';

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

            error_log("User data retrieved: " . print_r($user, true));
            
            if ($user) {
                // Log the entered and stored password for verification
                $trimmed_password = trim($password);
                error_log("Password entered: '" . $trimmed_password . "'");
                error_log("Length of entered password: " . strlen($trimmed_password));
                error_log("Stored hashed password: '" . $user['password'] . "'");
                error_log("Length of stored hashed password: " . strlen($user['password']));
                
                // Verify the password
                $isPasswordCorrect = password_verify($trimmed_password, $user['password']);
                error_log("Password verification result: " . ($isPasswordCorrect ? 'true' : 'false'));
                
                if ($isPasswordCorrect) {
                    // If the password is correct, set session variables
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['last_name'] = $user['last_name'];
                    $_SESSION['first_name'] = $user['first_name'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role_id'] = $user['role_id'];
                    header('Location: ../index.php');
                    exit();
                } else {
                    $message = 'Identifiant ou mot de passe incorrect';
                    error_log("Password verification failed");
                }
            } else {
                $message = 'Utilisateur non trouvé';
                error_log("User not found");
            }
        } catch (Exception $e) {
            $message = 'Erreur : ' . $e->getMessage();
            error_log("Exception: " . $e->getMessage());
        }
    } elseif (isset($_POST['form_type']) && $_POST['form_type'] == 'register') {
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $phone = $_POST['phone'];
        
        // Champs d'adresse
        $deliveryAddress = $_POST['delivery_address'];
        $addressComplement = $_POST['address_complement'];
        $postalCode = $_POST['postal_code'];
        $city = $_POST['city'];
        $billingAddress = $_POST['billing_address'];

        if ($password !== $confirm_password) {
            $message = 'Les mots de passe ne correspondent pas';
        } else {
            try {
                $users = new Users();
                $user_id = $users->create_user($last_name, $first_name, $email, $password, $phone);
                
                // Enregistrer l'adresse
                $db = new Database();
                $address = new Address($db);
                $address->addAddress($user_id, $deliveryAddress, $addressComplement, $postalCode, $city, $billingAddress);
                
                $_SESSION['register_success'] = 'Félicitations, votre compte a été créé!';
                header('Location: loginRegister.php');
                exit();
            } catch (Exception $e) {
                $message = 'Erreur : ' . $e->getMessage();
                error_log("Exception: " . $e->getMessage());
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
                    <input type="email" name="email" id="register_email" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="register_email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="password" id="register_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="register_password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Mot de passe</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="password" name="confirm_password" id="confirm_password" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="confirm_password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirmer le mot de passe</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="phone" id="phone" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="phone" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Téléphone</label>
                </div>
                <!-- Champs pour les adresses -->
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="delivery_address" id="delivery_address" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="delivery_address" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Adresse de livraison</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="address_complement" id="address_complement" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="address_complement" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Complément d'adresse</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="postal_code" id="postal_code" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="postal_code" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Code postal</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <input type="text" name="city" id="city" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="city" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Ville</label>
                </div>
                <div id="passwordError" class="text-red-500 text-sm mt-2"></div>
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
            <a href="#" class="text-blue-600 hover:underline" onclick="openResetPasswordModal()">Vous avez oublié votre mot de passe ?</a>
            <br>
            <a href="#" id="toggleLoginMethod" class="text-blue-600 hover:underline">S'identifier avec son numéro de téléphone</a>
            <br>
        </div>
    </main>
    <!-- Modale de réinitialisation de mot de passe -->
    <div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: none;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="closeResetPasswordModal()">
                <i class="fas fa-times"></i>
            </button>
            <form action="../api/sendResetLink.php" method="post">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Réinitialisation du mot de passe</h3>
                    <div class="mt-2 px-7 py-3">
                        <label for="email">Entrez votre adresse email:</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <div class="items-center px-4 py-3">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Envoyer le lien de réinitialisation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="../javascript/loginRegister.js"></script>
</body>
</html>
