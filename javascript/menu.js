document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('[data-dropdown-toggle]');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const dropdownId = this.getAttribute('data-dropdown-toggle');
            const dropdown = document.getElementById(dropdownId);

            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        });
    });
});
