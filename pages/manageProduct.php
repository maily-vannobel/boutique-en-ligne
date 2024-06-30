<?php
require_once __DIR__ . '/../classes/Products.php';
require_once __DIR__ . '/../classes/ProductFilters.php';
require_once __DIR__ . '/../classes/ProductImages.php';
require_once __DIR__ . '/../classes/ProductSubcategories.php';

$products = new Products();
$productFilters = new ProductFilters();
$productSubcategories = new ProductSubcategories();
$productImages = new ProductImages();

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

$allProducts = $products->searchProducts($searchTerm);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        .image-container {
            max-width: 100px;
            max-height: 100px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        .image-container img {
            max-width: 100px;
            margin-bottom: 5px;
        }
    </style>
    <script>
        function deleteProduct(productId) {
            if (!confirm("Êtes-vous sûr de vouloir supprimer ce produit ?")) {
                return;
            }

            fetch('../api/deleteProduct.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: productId })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                alert(data.message);
                if (data.message === 'Produit supprimé avec succès') {
                    location.reload();
                }
            })
            .catch(error => console.error('Erreur:', error));
        }

        function searchProducts(searchTerm) {
            fetch('../api/searchProducts.php?search=' + encodeURIComponent(searchTerm))
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('tbody');
                tableBody.innerHTML = ''; // Clear the current table content

                data.forEach(product => {
                    const images = product.images.map(image => `<img src="${image.url}" alt="Product Image">`).join('');
                    tableBody.innerHTML += `
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left">${product.product_id}</td>
                            <td class="py-3 px-6 text-left">${product.product_name}</td>
                            <td class="py-3 px-6 text-left">
                                <div class="image-container">
                                    ${images}
                                </div>
                            </td>
                            <td class="py-3 px-6 text-left">${product.quantity_weight}</td>
                            <td class="py-3 px-6 text-left">${product.price}</td>
                            <td class="py-3 px-6 text-center">
                                <a href="editProduct.php?id=${product.product_id}" class="text-blue-500 hover:text-blue-700">Modifier</a>
                                <button onclick="deleteProduct(${product.product_id})" class="text-red-500 hover:text-red-700">Supprimer</button>
                            </td>
                        </tr>
                    `;
                });
            })
            .catch(error => console.error('Erreur:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            searchInput.addEventListener('input', function() {
                searchProducts(this.value);
            });
        });
    </script>
</head>
<body class="bg-gray-100">
    <?php include '../includes/header.php'; ?>
    <div class="container mx-auto p-4 sm:p-8">
        <h1 class="text-2xl font-bold mb-4">Gestion des Produits</h1>
        <form method="GET" class="mb-4 flex flex-col sm:flex-row items-center">
            <input type="text" name="search" placeholder="Rechercher un produit" class="p-2 border rounded w-full sm:w-auto mb-2 sm:mb-0 sm:mr-2" value="<?php echo htmlspecialchars($searchTerm); ?>">
            <button type="submit" class="p-2 bg-blue-500 text-white rounded w-full sm:w-auto">Rechercher</button>
        </form>

        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-max w-full table-auto">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">ID</th>
                        <th class="py-3 px-6 text-left">Nom du produit</th>
                        <th class="py-3 px-6 text-left">Images</th>
                        <th class="py-3 px-6 text-left">Quantité/Poids</th>
                        <th class="py-3 px-6 text-left">Prix</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php foreach ($allProducts as $product): 
                        $images = $productImages->getImagesByProductId($product['product_id']);
                    ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($product['product_id']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($product['product_name']); ?></td>
                        <td class="py-3 px-6 text-left">
                            <div class="image-container">
                                <?php foreach (array_slice($images, 0, 3) as $image): ?>
                                    <img src="<?php echo htmlspecialchars($image['url']); ?>" alt="Product Image">
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($product['quantity_weight']); ?></td>
                        <td class="py-3 px-6 text-left"><?php echo htmlspecialchars($product['price']); ?></td>
                        <td class="py-3 px-6 text-center">
                            <a href="editProduct.php?id=<?php echo $product['product_id']; ?>" class="text-blue-500 hover:text-blue-700">Modifier</a>
                            <button onclick="deleteProduct(<?php echo $product['product_id']; ?>)" class="text-red-500 hover:text-red-700">Supprimer</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
