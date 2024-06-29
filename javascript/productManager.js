document.addEventListener("DOMContentLoaded", () => {
    loadProducts();
    loadCategoriesAndFilters();

    const searchElement = document.getElementById("search");
    if (searchElement) {
        searchElement.addEventListener("input", handleSearchInput);
    }

    document.body.addEventListener("click", handleBodyClick);
});

let allProducts = [];
let allCategories = [];
let allFilters = [];
let subcategoriesByCategory = {};

function loadProducts() {
    axios
        .get("../api/getAllProducts.php")
        .then(response => {
            allProducts = response.data;
            displayProducts(allProducts);
        })
        .catch(error => {
            console.error("Erreur lors du chargement des produits :", error);
        });
}

function loadCategoriesAndFilters() {
    axios
        .get("../api/getAllCategoriesAndFilters.php")
        .then(response => {
            allCategories = response.data.categories;
            allFilters = response.data.filters;
            const allSubcategories = response.data.subcategories;
            allSubcategories.forEach(subcategory => {
                if (!subcategoriesByCategory[subcategory.category_id]) {
                    subcategoriesByCategory[subcategory.category_id] = [];
                }
                subcategoriesByCategory[subcategory.category_id].push(
                    subcategory
                );
            });
        })
        .catch(error => {
            console.error(
                "Erreur lors du chargement des catégories et filtres :",
                error
            );
        });
}

function handleSearchInput(event) {
    const term = event.target.value.toLowerCase();
    const results = allProducts.filter(
        product =>
            product.product_name &&
            product.product_name.toLowerCase().includes(term)
    );
    displayProducts(results);
}

function displayProducts(products) {
    const accordion = document.getElementById("productsAccordion");
    accordion.innerHTML = "";
    products.forEach(product => {
        const item = createProductAccordionItem(product);
        accordion.appendChild(item);
    });

    // Initialiser les composants d'accordéon après avoir ajouté les éléments dynamiquement
    new Accordion(accordion);
}

function createProductAccordionItem(product) {
    const item = document.createElement("div");
    item.classList.add(
        "accordion-item",
        "bg-white",
        "border",
        "border-gray-200"
    );

    const imageUrl =
        product.images && product.images.length > 0
            ? product.images[0].url
            : "default_image.png";
    item.innerHTML = `
        <h2 id="accordion-heading-${product.product_id}">
            <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border-b border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-body-${
                product.product_id
            }" aria-expanded="false" aria-controls="accordion-body-${
        product.product_id
    }">
                <div class="flex items-center">
                    <img src="${imageUrl}" alt="${
        product.product_name
    }" class="w-16 h-16 object-cover mr-4">
                    <span>${product.product_name}</span>
                </div>
                <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </h2>
        <div id="accordion-body-${
            product.product_id
        }" class="hidden" aria-labelledby="accordion-heading-${
        product.product_id
    }">
            <div class="p-5">
                <form id="editProductForm-${product.product_id}" class="mt-4">
                    <input type="hidden" name="product_id" value="${
                        product.product_id
                    }">
                    <div>
                        <label for="edit_product_name-${
                            product.product_id
                        }">Nom du Produit:</label>
                        <input type="text" id="edit_product_name-${
                            product.product_id
                        }" name="product_name" value="${
        product.product_name
    }" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="mt-2">
                        <label for="edit_description-${
                            product.product_id
                        }">Description:</label>
                        <textarea id="edit_description-${
                            product.product_id
                        }" name="description" class="w-full px-3 py-2 border rounded-lg">${
        product.description
    }</textarea>
                    </div>
                    <div class="mt-2">
                        <label for="edit_quantity_weight-${
                            product.product_id
                        }">Quantité/Poids:</label>
                        <input type="text" id="edit_quantity_weight-${
                            product.product_id
                        }" name="quantity_weight" value="${
        product.quantity_weight
    }" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="mt-2">
                        <label for="edit_price-${
                            product.product_id
                        }">Prix:</label>
                        <input type="text" id="edit_price-${
                            product.product_id
                        }" name="price" value="${
        product.price
    }" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <div class="mt-2">
                        <label for="edit_category-${
                            product.product_id
                        }">Catégorie:</label>
                        <select id="edit_category-${
                            product.product_id
                        }" name="category" class="w-full px-3 py-2 border rounded-lg">
                            ${allCategories
                                .map(
                                    category =>
                                        `<option value="${
                                            category.category_id
                                        }" ${
                                            category.category_id ===
                                            product.category_id
                                                ? "selected"
                                                : ""
                                        }>${category.category_name}</option>`
                                )
                                .join("")}
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="edit_subcategories-${
                            product.product_id
                        }">Sous-catégories:</label>
                        <select id="edit_subcategories-${
                            product.product_id
                        }" name="subcategories[]" multiple class="w-full px-3 py-2 border rounded-lg">
                            ${(
                                subcategoriesByCategory[product.category_id] ||
                                []
                            )
                                .map(
                                    subcategory =>
                                        `<option value="${
                                            subcategory.subcategories_id
                                        }" ${
                                            product.subcategories &&
                                            product.subcategories.includes(
                                                subcategory.subcategories_id
                                            )
                                                ? "selected"
                                                : ""
                                        }>${
                                            subcategory.subcategories_name
                                        }</option>`
                                )
                                .join("")}
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="edit_filters-${
                            product.product_id
                        }">Filtres:</label>
                        <select id="edit_filters-${
                            product.product_id
                        }" name="filters[]" multiple class="w-full px-3 py-2 border rounded-lg">
                            ${allFilters
                                .map(
                                    filter =>
                                        `<option value="${filter.filter_id}" ${
                                            product.filters &&
                                            product.filters.includes(
                                                filter.filter_id
                                            )
                                                ? "selected"
                                                : ""
                                        }>${filter.filter_value}</option>`
                                )
                                .join("")}
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="edit_images-${
                            product.product_id
                        }">URLs des Images:</label>
                        <input type="text" id="edit_images-${
                            product.product_id
                        }" name="images" value="${product.images
        .map(img => img.url)
        .join(", ")}" class="w-full px-3 py-2 border rounded-lg">
                    </div>
                    <button type="button" class="update-product-btn mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg" data-product-id="${
                        product.product_id
                    }">Enregistrer les modifications</button>
                    <button type="button" class="delete-product-btn mt-4 ml-2 px-4 py-2 bg-red-500 text-white rounded-lg" data-product-id="${
                        product.product_id
                    }">Supprimer</button>
                </form>
            </div>
        </div>
    `;
    return item;
}

function handleBodyClick(event) {
    if (event.target.classList.contains("update-product-btn")) {
        const productId = event.target.dataset.productId;
        showEditForm(productId);
    }
    if (event.target.classList.contains("delete-product-btn")) {
        const productId = event.target.dataset.productId;
        deleteProduct(productId);
    }
}

function showEditForm(productId) {
    const productForm = document.getElementById(`editProductForm-${productId}`);
    const formData = new FormData(productForm);
    const productData = {};
    formData.forEach((value, key) => {
        productData[key] = value;
    });

    axios
        .post("../api/updateProduct.php", productData)
        .then(response => {
            alert(response.data.message);
            if (response.data.message.includes("succès")) {
                loadProducts();
            }
        })
        .catch(error => {
            console.error("Erreur lors de la mise à jour du produit :", error);
            alert("Erreur lors de la mise à jour du produit");
        });
}

function deleteProduct(productId) {
    if (confirm("Voulez-vous vraiment supprimer ce produit?")) {
        axios
            .post("../api/deleteProduct.php", { id: productId })
            .then(response => {
                alert(response.data.message);
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
