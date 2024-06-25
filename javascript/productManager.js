$(document).ready(function () {
    $("#addProductForm").on("submit", function (event) {
        event.preventDefault();

        var form = $(this);
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: new FormData(form[0]),
            contentType: false,
            processData: false,
            success: function (data) {
                var messageContainer = $("#messageContainer");
                if (data.includes("succès")) {
                    messageContainer.html(
                        '<p class="text-green-500">Produit ajouté avec succès!</p>'
                    );
                    form.trigger("reset");
                } else {
                    messageContainer.html(
                        '<p class="text-red-500">Erreur lors de l\'ajout du produit.</p>'
                    );
                }
            },
            error: function () {
                $("#messageContainer").html(
                    '<p class="text-red-500">Erreur lors de la connexion au serveur.</p>'
                );
            },
        });
    });
});

function addImageUrlField() {
    var container = $("#image_urls_container");
    $("<input>", {
        type: "text",
        name: "image_urls[]",
        class: "w-full px-5 py-1 text-gray-700 bg-gray-200 rounded mt-2",
    }).appendTo(container);
}

function removeImageUrlField() {
    var inputs = $("#image_urls_container input[name='image_urls[]']");
    if (inputs.length > 1) {
        inputs.last().remove();
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let allFilters = JSON.parse(
        document.getElementById("allFilters").textContent
    );
    let selectedFilters = JSON.parse(
        document.getElementById("selectedFilters").textContent
    );

    $("#filter").autocomplete({
        source: function (request, response) {
            let results = $.ui.autocomplete.filter(
                allFilters.map(f => f.filter_value),
                request.term
            );
            response(results.slice(0, 10));
        },
        select: function (event, ui) {
            addFilter(ui.item.value);
            $(this).val("");
            return false;
        },
    });

    function addFilter(filterValue) {
        let filter = allFilters.find(f => f.filter_value === filterValue);
        if (
            filter &&
            !$(`#selected-filters .filter[data-id='${filter.filter_id}']`)
                .length
        ) {
            let filterDiv = $(`
                <div class="filter bg-gray-200 rounded px-2 py-1 m-1 flex items-center" data-id="${filter.filter_id}">
                    <span>${filter.filter_type}: ${filterValue}</span>
                    <button type="button" class="ml-2 text-red-500 remove-filter">✖</button>
                    <input type="hidden" name="filters[]" value="${filter.filter_id}">
                </div>
            `);
            $("#selected-filters").append(filterDiv);
        }
    }

    $("#selected-filters").on("click", ".remove-filter", function () {
        $(this).parent().remove();
    });

    // Charger les filtres déjà sélectionnés si nécessaire
    selectedFilters.forEach(function (filter) {
        addFilter(filter.filter_value);
    });
});
