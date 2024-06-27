function validateLoginForm() {
    const identifier = document.getElementById('identifier');
    const phoneIdentifier = document.getElementById('phone_identifier');
    const password = document.getElementById('password').value;
    const loginError = document.getElementById('loginError');
    let errorMessage = '';

    if (document.getElementById('login_method').value === 'email' && !identifier.value) {
        errorMessage += 'Veuillez entrer votre email. ';
    }
    if (document.getElementById('login_method').value === 'phone' && !phoneIdentifier.value) {
        errorMessage += 'Veuillez entrer votre numéro de téléphone. ';
    }
    if (!password) {
        errorMessage += 'Veuillez entrer votre mot de passe. ';
    }

    if (errorMessage) {
        loginError.textContent = errorMessage;
        return false;
    } else {
        loginError.textContent = '';
        return true;
    }
}

document.getElementById('identifier').addEventListener('input', validateLoginForm);
document.getElementById('phone_identifier').addEventListener('input', validateLoginForm);
document.getElementById('password').addEventListener('input', validateLoginForm);

document.getElementById('toggleLoginMethod').addEventListener('click', function (event) {
    event.preventDefault();
    const loginMethod = document.getElementById('login_method');
    const emailLogin = document.getElementById('email_login');
    const phoneLogin = document.getElementById('phone_login');
    const identifier = document.getElementById('identifier');
    const phoneIdentifier = document.getElementById('phone_identifier');

    if (loginMethod.value === 'email') {
        loginMethod.value = 'phone';
        emailLogin.style.display = 'none';
        identifier.removeAttribute('required');
        identifier.setAttribute('disabled', 'disabled');

        phoneLogin.style.display = 'block';
        phoneIdentifier.setAttribute('required', 'required');
        phoneIdentifier.removeAttribute('disabled');
        
        document.getElementById('toggleLoginMethod').textContent = "S'identifier avec son email";
    } else {
        loginMethod.value = 'email';
        phoneLogin.style.display = 'none';
        phoneIdentifier.removeAttribute('required');
        phoneIdentifier.setAttribute('disabled', 'disabled');

        emailLogin.style.display = 'block';
        identifier.setAttribute('required', 'required');
        identifier.removeAttribute('disabled');
        
        document.getElementById('toggleLoginMethod').textContent = "S'identifier avec son numéro de téléphone";
    }
});
