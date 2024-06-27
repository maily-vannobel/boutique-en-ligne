document.addEventListener("DOMContentLoaded", () => {
    const buttons = document.querySelectorAll("[data-dropdown-toggle]");

    buttons.forEach(button => {
        button.addEventListener("click", function (event) {
            event.stopPropagation(); // Arrête la propagation pour éviter des conflits avec l'écouteur de document
            const dropdownId = this.getAttribute("data-dropdown-toggle");
            const dropdown = document.getElementById(dropdownId);
            const allDropdowns = document.querySelectorAll(".dropdown");

            // Fermer tous les dropdowns avant d'en ouvrir un nouveau
            allDropdowns.forEach(dropdown => {
                dropdown.classList.add("hidden");
            });

            // Toggle le dropdown actuel
            if (dropdown.classList.contains("hidden")) {
                dropdown.classList.remove("hidden");
            } else {
                dropdown.classList.add("hidden");
            }
        });
    });

    // Ajouter un écouteur de clic au document pour fermer tous les dropdowns lorsque l'on clique en dehors
    document.addEventListener("click", () => {
        const allDropdowns = document.querySelectorAll(".dropdown");
        allDropdowns.forEach(dropdown => {
            dropdown.classList.add("hidden");
        });
    });

    // Gestion du menu burger pour le menu mobile
    const burgerButton = document.getElementById('burger-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    burgerButton.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
    });

    // Gestion du menu Admin
    const adminMenuButton = document.getElementById('adminMenuButton');
    const adminMenu = document.getElementById('adminMenu');

    if (adminMenuButton && adminMenu) {
        adminMenuButton.addEventListener('click', function (event) {
            event.stopPropagation();
            adminMenu.classList.toggle('hidden');
        });
    }
});
