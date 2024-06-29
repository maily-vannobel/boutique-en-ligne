document.addEventListener('DOMContentLoaded', () => {
    const profileIcon = document.getElementById('profileIcon');
    const profileMenu = document.getElementById('profileMenu');
    const burgerButton = document.getElementById('burger-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const adminMenuButton = document.getElementById('adminMenuButton');
    const adminMenu = document.getElementById('adminMenu');
    const buttons = document.querySelectorAll("[data-dropdown-toggle]");

    // Gestion de l'icone Profil
    if (profileIcon && profileMenu) {
        profileIcon.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            if (profileMenu.classList.contains('hidden')) {
                profileMenu.classList.remove('hidden');
            } else {
                profileMenu.classList.add('hidden');
            }
        });
    }

    // Fermer le menu lorsqu'on clique en dehors
    document.addEventListener('click', function (event) {
        if (profileIcon && profileMenu) {
            if (!profileIcon.contains(event.target) && !profileMenu.contains(event.target)) {
                if (!profileMenu.classList.contains('hidden')) {
                    profileMenu.classList.add('hidden');
                }
            }
        }
    });

    // Gestion du menu burger pour le menu mobile
    if (burgerButton && mobileMenu) {
        burgerButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Gestion du menu Admin
    if (adminMenuButton && adminMenu) {
        adminMenuButton.addEventListener('click', function (event) {
            event.stopPropagation();
            adminMenu.classList.toggle('hidden');
        });
    }

    // Gestion des dropdowns généraux
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
});
