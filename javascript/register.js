function validatePassword() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const passwordError = document.getElementById('passwordError');
    let errorMessage = '';

    if (password.length < 8) {
        errorMessage += 'Le mot de passe doit contenir au moins 8 caractères. ';
    }
    if (!/[0-9]/.test(password)) {
        errorMessage += 'Le mot de passe doit contenir au moins un chiffre. ';
    }
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        errorMessage += 'Le mot de passe doit contenir au moins un caractère spécial. ';
    }
    if (password !== confirmPassword) {
        errorMessage += 'Les mots de passe ne correspondent pas. ';
    }

    if (errorMessage) {
        passwordError.textContent = errorMessage;
        return false;
    } else {
        passwordError.textContent = '';
        return true;
    }
}

function validateForm() {
    return validatePassword();
}

document.getElementById('password').addEventListener('input', validatePassword);
document.getElementById('confirm_password').addEventListener('input', validatePassword);
