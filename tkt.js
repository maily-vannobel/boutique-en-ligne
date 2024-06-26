document.addEventListener("DOMContentLoaded", function () {
    let form = document.getElementById("addProductForm");

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(form);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", form.action, true);
        xhr.onload = function () {
            let messageContainer = document.getElementById("messageContainer");
            if (xhr.responseText.includes("succès")) {
                messageContainer.innerHTML =
                    '<p class="text-green-500">Produit ajouté avec succès!</p>';
                form.reset();
            } else {
                messageContainer.innerHTML =
                    '<p class="text-red-500">Erreur lors de l\'ajout du produit.</p>';
            }
        };
        xhr.onerror = function () {
            document.getElementById("messageContainer").innerHTML =
                '<p class="text-red-500">Erreur lors de la connexion au serveur.</p>';
        };
        xhr.send(formData);
    });

    // Functions to add and remove subcategory fields
    function addSubcategoryField() {
        let subcategorySelect = document.getElementById("subcategory-select");
        let selectedValue = subcategorySelect.value;
        let selectedText =
            subcategorySelect.options[subcategorySelect.selectedIndex].text;
        if (selectedValue) {
            addSubcategory(selectedText, selectedValue);
            subcategorySelect.value = "";
        }
    }

    function addSubcategory(subcategoryName, subcategoryId) {
        if (
            !document.querySelector(
                `#selected-subcategories .subcategory[data-id='${subcategoryId}']`
            )
        ) {
            let subcategoryDiv = document.createElement("div");
            subcategoryDiv.className =
                "subcategory bg-gray-200 rounded px-2 py-1 m-1 flex items-center";
            subcategoryDiv.setAttribute("data-id", subcategoryId);
            subcategoryDiv.innerHTML = `
                <span>${subcategoryName}</span>
                <button type="button" class="ml-2 text-red-500 remove-subcategory">✖</button>
                <input type="hidden" name="subcategories[]" value="${subcategoryId}">
            `;
            document
                .getElementById("selected-subcategories")
                .appendChild(subcategoryDiv);
        }
    }

    document
        .getElementById("addSubcategoryButton")
        .addEventListener("click", addSubcategoryField);

    document
        .getElementById("removeSubcategoryButton")
        .addEventListener("click", function () {
            let container = document.getElementById("selected-subcategories");
            let subcategories = container.querySelectorAll(".subcategory");
            if (subcategories.length > 0) {
                container.removeChild(subcategories[subcategories.length - 1]);
            }
        });

    document
        .getElementById("selected-subcategories")
        .addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-subcategory")) {
                event.target.parentNode.remove();
            }
        });

    // Autocomplete for filters
    let allFilters = JSON.parse(
        document.getElementById("allFilters").textContent
    );
    let selectedFilters = JSON.parse(
        document.getElementById("selectedFilters").textContent
    );

    let filterInput = document.getElementById("filter");
    filterInput.addEventListener("input", function () {
        let term = filterInput.value.toLowerCase();
        let results = allFilters
            .filter(f => f.filter_value.toLowerCase().includes(term))
            .slice(0, 10);
        showAutocompleteSuggestions(results);
    });

    function showAutocompleteSuggestions(results) {
        let autocompleteList = document.getElementById("autocomplete-list");
        if (!autocompleteList) {
            autocompleteList = document.createElement("div");
            autocompleteList.setAttribute("id", "autocomplete-list");
            autocompleteList.className = "autocomplete-items";
            filterInput.parentNode.appendChild(autocompleteList);
        }
        autocompleteList.innerHTML = "";
        results.forEach(result => {
            let item = document.createElement("div");
            item.innerText = result.filter_value;
            item.addEventListener("click", function () {
                addFilter(result.filter_value);
                filterInput.value = "";
                autocompleteList.innerHTML = "";
            });
            autocompleteList.appendChild(item);
        });
    }

    function addFilter(filterValue) {
        let filter = allFilters.find(f => f.filter_value === filterValue);
        if (
            filter &&
            !document.querySelector(
                `#selected-filters .filter[data-id='${filter.filter_id}']`
            )
        ) {
            let filterDiv = document.createElement("div");
            filterDiv.className =
                "filter bg-gray-200 rounded px-2 py-1 m-1 flex items-center";
            filterDiv.setAttribute("data-id", filter.filter_id);
            filterDiv.innerHTML = `
                <span>${filter.filter_type}: ${filterValue}</span>
                <button type="button" class="ml-2 text-red-500 remove-filter">✖</button>
                <input type="hidden" name="filters[]" value="${filter.filter_id}">
            `;
            document.getElementById("selected-filters").appendChild(filterDiv);
        }
    }

    document
        .getElementById("selected-filters")
        .addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-filter")) {
                event.target.parentNode.remove();
            }
        });

    // Charger les filtres déjà sélectionnés si nécessaire
    selectedFilters.forEach(function (filter) {
        addFilter(filter.filter_value);
    });
});
