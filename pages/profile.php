<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../classes/Database.php';
require_once '../classes/Users.php';

if (!isset($_SESSION['user_id'])) {
    exit();
}

$user_id = $_SESSION['user_id'];
$users = new Users();
$user = $users->get_user_by_id($user_id);

$cart_items = $_SESSION['cart'] ?? [];

include '../includes/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Pup Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/profile.css">
</head>
<body class="bg-gray-100">

<main class="max-w-7xl mx-auto mt-10 p-4">
    <!-- Section Informations générales -->
    <div id="general-info" class="profile-section">
        <h2 class="text-2xl font-semibold">Informations générales</h2>
        <div class="p-5 border border-gray-200 rounded-lg">
            <?php if (isset($_SESSION['message'])): ?>
                <div id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                        </svg>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div class="ms-3 text-sm font-normal"><?= htmlspecialchars($_SESSION['message']) ?></div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-success" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                        </svg>
                        <span class="sr-only">Error icon</span>
                    </div>
                    <div class="ms-3 text-sm font-normal"><?= htmlspecialchars($_SESSION['error']) ?></div>
                    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-danger" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <form method="post" action="../api/updateProfil.php">
                <div class="mb-5">
                    <input type="text" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 " placeholder="Prénom" required />
                </div>
                <div class="mb-5">
                    <input type="text" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 " placeholder="Nom" required />
                </div>
                <div class="mb-5">
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 " placeholder="name@flowbite.com" required />
                </div>
                <div class="mb-5">
                    <input type="text" id="phone-input" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" aria-describedby="helper-text-explanation" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-yellow-500 focus:border-yellow-500 " pattern="[0-9]{10}" placeholder="Numéro de téléphone" required />
                </div>
                <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Mettre à jour</button>
            </form>
            <!-- Bouton pour ouvrir la modale -->
            <button data-modal-target="change-password-modal" data-modal-toggle="change-password-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-5" type="button">
                Modifier le mot de passe
            </button>
        </div>
    </div>

    <!-- Section Adresses -->
    <div id="addresses" class="profile-section hidden">
        <h2 class="text-2xl font-semibold">Adresses</h2>
        <div class="p-5 border border-gray-200 rounded-lg">
        </div>
    </div>

    <!-- Section Moyens de Paiement -->
    <div id="payment-methods" class="profile-section hidden">
        <h2 class="text-2xl font-semibold">Moyens de Paiement</h2>
        <div class="p-5 border border-gray-200 rounded-lg">
        </div>
    </div>
</main>

<!-- Main modal -->
<div id="change-password-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Modifier le mot de passe
                </h3>
                <button type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="change-password-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form id="change-password-form" method="post" action="../api/updatePassword.php" class="space-y-4">
                    <div>
                        <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ancien mot de passe</label>
                        <div class="relative">
                            <input type="password" name="old_password" id="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required />
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 toggle-password-visibility" data-target="old_password">
                                <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.486 5 12 5c4.514 0 8.268 2.943 9.542 7-1.274 4.057-5.028 7-9.542 7-4.514 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nouveau mot de passe</label>
                        <div class="relative">
                            <input type="password" name="new_password" id="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required />
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 toggle-password-visibility" data-target="new_password">
                                <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.486 5 12 5c4.514 0 8.268 2.943 9.542 7-1.274 4.057-5.028 7-9.542 7-4.514 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmer le nouveau mot de passe</label>
                        <div class="relative">
                            <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="••••••••" required />
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 toggle-password-visibility" data-target="confirm_password">
                                <svg class="h-5 w-5 text-gray-700 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                    <path d="M2.458 12C3.732 7.943 7.486 5 12 5c4.514 0 8.268 2.943 9.542 7-1.274 4.057-5.028 7-9.542 7-4.514 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Menu bas de page -->
<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200">
    <div class="grid h-full max-w-lg grid-cols-3 mx-auto font-medium">
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group" onclick="showSection('general-info')">
            <svg class="w-5 h-5 mb-2 text-gray-500 group-hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
            </svg>
            <span class="text-sm text-gray-500 group-hover:text-blue-600">Informations</span>
        </button>
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group" onclick="showSection('addresses')">
            <svg class="w-5 h-5 mb-2 text-gray-500 group-hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M11.074 4 8.442.408A.95.95 0 0 0 7.014.254L2.926 4h8.148ZM9 13v-1a4 4 0 0 1 4-4h6V6a1 1 0 0 0-1-1H1a1 1 0 0 0-1 1v13a1 1 0 0 0 1 1h17a1 1 0 0 0 1-1v-2h-6a4 4 0 0 1-4-4Z"/>
                <path d="M19 10h-6a2 2 0 0 0-2 2v1a2 2 0 0 0 2 2h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1Zm-4.5 3.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2ZM12.62 4h2.78L12.539.41a1.086 1.086 0 1 0-1.7 1.352L12.62 4Z"/>
            </svg>
            <span class="text-sm text-gray-500 group-hover:text-blue-600">Adresses</span>
        </button>
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 group" onclick="showSection('payment-methods')">
            <svg class="w-5 h-5 mb-2 text-gray-500 group-hover:text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
            </svg>
            <span class="text-sm text-gray-500 group-hover:text-blue-600">Paiement</span>
        </button>
    </div>
</div>

<script src="../javascript/profile.js"></script>

</body>
</html>
