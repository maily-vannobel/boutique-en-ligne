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
            if (target.classList.contains('hidden')) {
                target.classList.remove('hidden');
            } else {
                target.classList.add('hidden');
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
        });

        modalCloseButton.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    }

    // Modales pour les adresses
    const modalToggleButtons = document.querySelectorAll('[data-modal-toggle]');
    modalToggleButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const targetId = button.getAttribute('data-modal-toggle');
            const targetModal = document.getElementById(targetId);
            if (targetModal) {
                targetModal.classList.toggle('hidden');
            }
        });
    });

    const modalCloseButtons = document.querySelectorAll('[data-modal-hide]');
    modalCloseButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            const targetId = button.getAttribute('data-modal-hide');
            const targetModal = document.getElementById(targetId);
            if (targetModal) {
                targetModal.classList.add('hidden');
            }
        });
    });

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
