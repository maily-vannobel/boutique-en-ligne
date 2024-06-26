<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadProducts();

        document.getElementById('search').addEventListener('input', function(event) {
            const term = event.target.value;
            searchProducts(term);
        });
    });

    function loadProducts() {
        axios.get('/api/getAllProducts.php')
            .then(response => {
                const products = response.data;
                const tbody = document.getElementById('productsTable');
                tbody.innerHTML = '';
                products.forEach(product => {
                    const row = createProductRow(product);
                    tbody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Erreur lors du chargement des produits :', error);
            });
    }

    function searchProducts(term) {
        axios.post('/api/searchProducts.php', { term })
            .then(response => {
                const products = response.data;
                const tbody = document.getElementById('productsTable');
                tbody.innerHTML = '';
                products.forEach(product => {
                    const row = createProductRow(product);
                    tbody.appendChild(row);
                });
            })
            .catch(error => {
                console.error('Erreur lors de la recherche des produits :', error);
            });
    }

    function createProductRow(product) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="py-2 px-4 border-b">${product.product_id}</td>
            <td class="py-2 px-4 border-b">${product.product_name}</td>
            <td class="py-2 px-4 border-b">${product.description}</td>
            <td class="py-2 px-4 border-b">${product.quantity_weight}</td>
            <td class="py-2 px-4 border-b">${product.price}</td>
            <td class="py-2 px-4 border-b">${product.category_name}</td>
            <td class="py-2 px-4 border-b">${product.filters.map(filter => filter.filter_value).join(', ')}</td>
            <td class="py-2 px-4 border-b">
                ${product.images.map(image => `<img src="${image.url}" class="h-16 w-16 object-cover mx-1">`).join('')}
            </td>
            <td class="py-2 px-4 border-b">
                <button class="bg-blue-500 text-white px-2 py-1 rounded" onclick="editProduct(${product.product_id})">Modifier</button>
                <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteProduct(${product.product_id})">Supprimer</button>
            </td>
        `;
        return row;
    }

    function editProduct(id) {
        // Logique de modification du produit
    }

    function deleteProduct(id) {
        if (confirm('Voulez-vous vraiment supprimer ce produit?')) {
            axios.post('/api/deleteProduct.php', { id: id })
                .then(response => {
                    if (response.data.message) {
                        alert(response.data.message);
                    } else {
                        alert('Erreur : réponse invalide du serveur');
                    }
                    loadProducts();
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression du produit :', error);
                    alert('Erreur lors de la suppression du produit');
                });
        }
    }
    
</script>


</body>
</html>