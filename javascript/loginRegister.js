document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.getElementById('register-form');
    const loginForm = document.getElementById('login-form');
    const registerTab = document.getElementById('register-tab');
    const loginTab = document.getElementById('login-tab');

    function showRegister() {
        registerForm.style.display = 'block';
        loginForm.style.display = 'none';
        registerTab.classList.add('text-blue-500');
        registerTab.classList.remove('text-gray-500');
        loginTab.classList.add('text-gray-500');
        loginTab.classList.remove('text-blue-500');
    }

    function showLogin() {
        registerForm.style.display = 'none';
        loginForm.style.display = 'block';
        loginTab.classList.add('text-blue-500');
        loginTab.classList.remove('text-gray-500');
        registerTab.classList.add('text-gray-500');
        registerTab.classList.remove('text-blue-500');
    }

    // basculer entre formulaire d'inscription ou connexion
    registerTab.addEventListener('click', showRegister);
    loginTab.addEventListener('click', showLogin);

    const loginMethod = document.getElementById('login_method');
    const emailLogin = document.getElementById('email_login');
    const phoneLogin = document.getElementById('phone_login');
    const identifier = document.getElementById('identifier');
    const phoneIdentifier = document.getElementById('phone_identifier');
    const toggleLoginMethod = document.getElementById('toggleLoginMethod');

    // basculer entre connexion par mail ou téléphone
    toggleLoginMethod.addEventListener('click', function (event) {
        event.preventDefault();
        if (loginMethod.value === 'email') {
            loginMethod.value = 'phone';
            emailLogin.style.display = 'none';
            identifier.removeAttribute('required');
            identifier.setAttribute('disabled', 'disabled');

            phoneLogin.style.display = 'block';
            phoneIdentifier.setAttribute('required', 'required');
            phoneIdentifier.removeAttribute('disabled');

            toggleLoginMethod.textContent = "S'identifier avec son email";
        } else {
            loginMethod.value = 'email';
            phoneLogin.style.display = 'none';
            phoneIdentifier.removeAttribute('required');
            phoneIdentifier.setAttribute('disabled', 'disabled');

            emailLogin.style.display = 'block';
            identifier.setAttribute('required', 'required');
            identifier.removeAttribute('disabled');

            toggleLoginMethod.textContent = "S'identifier avec son numéro de téléphone";
        }
    });

    window.validateForm = function() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        if (password !== confirmPassword) {
            document.getElementById('passwordError').innerText = 'Les mots de passe ne correspondent pas';
            return false;
        }
        document.getElementById('passwordError').innerText = '';
        return true;
    };
});
