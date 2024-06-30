document.addEventListener("DOMContentLoaded", function () {
    const forms = document.querySelectorAll("form");
    forms.forEach(form => {
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            if (!confirm("Êtes-vous sûr de vouloir effectuer cette action ?")) {
                return;
            }

            const formData = new FormData(form);
            const action = form.dataset.action;
            const messageDiv = document.getElementById(`${action}Message`);

            fetch(`../api/filtering/${action}.php`, {
                method: "POST",
                body: formData,
            })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showMessage(
                            messageDiv,
                            `Action réussie : ${result.message}`,
                            "success"
                        );
                        if (action.includes("Category"))
                            updateCategorySelectors();
                        if (action.includes("Subcategory"))
                            updateSubcategorySelectors();
                        if (action.includes("Filter")) updateFilterSelectors();
                    } else {
                        showMessage(
                            messageDiv,
                            `Erreur : ${result.message}`,
                            "error"
                        );
                    }
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    showMessage(messageDiv, "Erreur de traitement", "error");
                });
        });
    });

    function showMessage(div, message, type) {
        div.textContent = message;
        div.className =
            type === "success"
                ? "bg-green-500 text-white p-4 rounded mb-6"
                : "bg-red-500 text-white p-4 rounded mb-6";
        div.classList.remove("hidden");
        setTimeout(() => {
            div.classList.add("hidden");
        }, 5000);
    }

    function updateCategorySelectors() {
        fetch("../api/filtering/getCategories.php")
            .then(response => response.json())
            .then(categories => {
                const categorySelects = document.querySelectorAll(
                    "select[name='category_id']"
                );
                categorySelects.forEach(select => {
                    while (select.firstChild) {
                        select.removeChild(select.firstChild);
                    }
                    categories.forEach(category => {
                        const option = document.createElement("option");
                        option.value = category.category_id;
                        option.textContent = category.category_name;
                        select.appendChild(option);
                    });
                });
            });
    }

    function updateSubcategorySelectors() {
        fetch("../api/filtering/getSubcategories.php")
            .then(response => response.json())
            .then(subcategories => {
                const subcategorySelects = document.querySelectorAll(
                    "select[name='subcategories_id']"
                );
                subcategorySelects.forEach(select => {
                    while (select.firstChild) {
                        select.removeChild(select.firstChild);
                    }
                    subcategories.forEach(subcategory => {
                        const option = document.createElement("option");
                        option.value = subcategory.subcategories_id;
                        option.textContent = subcategory.subcategories_name;
                        select.appendChild(option);
                    });
                });
            });
    }

    function updateFilterSelectors() {
        fetch("../api/filtering/getFilters.php")
            .then(response => response.json())
            .then(filters => {
                const filterSelects = document.querySelectorAll(
                    "select[name='filter_id']"
                );
                filterSelects.forEach(select => {
                    while (select.firstChild) {
                        select.removeChild(select.firstChild);
                    }
                    filters.forEach(filter => {
                        const option = document.createElement("option");
                        option.value = filter.filter_id;
                        option.textContent = `${filter.filter_value} (${filter.filter_type})`;
                        select.appendChild(option);
                    });
                });
            });
    }

    // Load initial data for all selectors
    updateCategorySelectors();
    updateSubcategorySelectors();
    updateFilterSelectors();
});
