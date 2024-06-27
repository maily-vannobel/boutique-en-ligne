<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script defer src="../javascript/productManager.js"></script>
</head>
<body class="bg-gray-100">

    <?php include '../includes/header.php'; ?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Liste des Produits</h1>
    <input type="text" id="search" placeholder="Rechercher un produit..." class="mb-4 p-2 border border-gray-300 rounded w-full">
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nom</th>
                <th class="py-2 px-4 border-b">Description</th>
                <th class="py-2 px-4 border-b">Quantité/Poids</th>
                <th class="py-2 px-4 border-b">Prix</th>
                <th class="py-2 px-4 border-b">Catégorie</th>
                <th class="py-2 px-4 border-b">Filtres</th>
                <th class="py-2 px-4 border-b">Images</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody id="productsTable" class="bg-white">
            <!-- Les produits seront insérés ici par JavaScript -->
        </tbody>
    </table>
</div>
</body>
</html>