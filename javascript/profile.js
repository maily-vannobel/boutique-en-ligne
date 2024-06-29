document.addEventListener('DOMContentLoaded', function () {
    const accordions = document.querySelectorAll('[data-accordion="collapse"]');
    
    accordions.forEach(accordion => {
        const buttons = accordion.querySelectorAll('button');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const target = document.querySelector(button.getAttribute('data-accordion-target'));
                const icon = button.querySelector('[data-accordion-icon]');
                
                if (target.classList.contains('hidden')) {
                    target.classList.remove('hidden');
                    target.classList.add('block');
                    icon.classList.add('rotate-180');
                } else {
                    target.classList.add('hidden');
                    target.classList.remove('block');
                    icon.classList.remove('rotate-180');
                }
            });
        });
    });
});
