document.addEventListener("DOMContentLoaded", function () {
    loadProducts();

    document
        .getElementById("search")
        .addEventListener("input", function (event) {
            const term = event.target.value;
            searchProducts(term);
        });
});

function loadProducts() {
    axios
        .get("/api/getAllProducts.php")
        .then(response => {
            const products = response.data;
            const tbody = document.getElementById("productsTable");
            tbody.innerHTML = "";
            products.forEach(product => {
                const row = createProductRow(product);
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Erreur lors du chargement des produits :", error);
        });
}

function searchProducts(term) {
    axios
        .post("/api/searchProducts.php", { term })
        .then(response => {
            const products = response.data;
            const tbody = document.getElementById("productsTable");
            tbody.innerHTML = "";
            products.forEach(product => {
                const row = createProductRow(product);
                tbody.appendChild(row);
            });
        })
        .catch(error => {
            console.error("Erreur lors de la recherche des produits :", error);
        });
}

function createProductRow(product) {
    const row = document.createElement("tr");
    row.innerHTML = `
        <td class="py-2 px-4 border-b">${product.product_id}</td>
        <td class="py-2 px-4 border-b">${product.product_name}</td>
        <td class="py-2 px-4 border-b">${product.description}</td>
        <td class="py-2 px-4 border-b">${product.quantity_weight}</td>
        <td class="py-2 px-4 border-b">${product.price}</td>
        <td class="py-2 px-4 border-b">${product.category_name}</td>
        <td class="py-2 px-4 border-b">${product.filters
            .map(filter => filter.filter_value)
            .join(", ")}</td>
        <td class="py-2 px-4 border-b">
            ${product.images
                .map(
                    image =>
                        `<img src="${image.url}" class="h-16 w-16 object-cover mx-1">`
                )
                .join("")}
        </td>
        <td class="py-2 px-4 border-b">
            <button class="bg-blue-500 text-white px-2 py-1 rounded" onclick="editProduct(${
                product.product_id
            })">Modifier</button>
            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteProduct(${
                product.product_id
            })">Supprimer</button>
        </td>
    `;
    return row;
}

function editProduct(id) {
    // Logique de modification du produit
}

function deleteProduct(id) {
    if (confirm("Voulez-vous vraiment supprimer ce produit?")) {
        axios
            .post("/api/deleteProduct.php", { id: id })
            .then(response => {
                if (response.data.message) {
                    alert(response.data.message);
                } else {
                    alert("Erreur : réponse invalide du serveur");
                }
                loadProducts();
            })
            .catch(error => {
                console.error(
                    "Erreur lors de la suppression du produit :",
                    error
                );
                alert("Erreur lors de la suppression du produit");
            });
    }
}