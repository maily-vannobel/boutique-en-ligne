document.addEventListener('DOMContentLoaded', function () {
    function showSection(sectionId) {
        document.querySelectorAll('.profile-section').forEach(function (section) {
            section.classList.add('hidden');
        });
        document.getElementById(sectionId).classList.remove('hidden');
    }

    const accordionButtons = document.querySelectorAll('button[data-accordion-target]');

    accordionButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const target = document.querySelector(button.getAttribute('data-accordion-target'));
            console.log('Valeur de data-accordion-target :', button.getAttribute('data-accordion-target'));
            console.log('Élément cible :', target);

            if (target.classList.contains('hidden')) {
                target.classList.remove('hidden');
                console.log('Élément affiché :', target);
            } else {
                target.classList.add('hidden');
                console.log('Élément caché :', target);
            }
        });
    });

    // Modale modification du MDP
    const modalToggleButton = document.querySelector('[data-modal-toggle="change-password-modal"]');
    const modal = document.getElementById('change-password-modal');
    const modalCloseButton = modal.querySelector('[data-modal-hide="change-password-modal"]');

    if (modalToggleButton && modal && modalCloseButton) {
        modalToggleButton.addEventListener('click', function () {
            modal.classList.toggle('hidden');
            console.log('Modale affichée :', modal);
        });

        modalCloseButton.addEventListener('click', function () {
            modal.classList.add('hidden');
            console.log('Modale cachée :', modal);
        });
    }

    // Visibilité des mots de passe
    const toggleButtons = document.querySelectorAll('.toggle-password-visibility');
    toggleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const target = button.getAttribute('data-target');
            togglePasswordVisibility(target);
        });
    });

    window.showSection = showSection;
    showSection('general-info');
});

function togglePasswordVisibility(fieldId) {
    let field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }
}
