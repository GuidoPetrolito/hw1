function controlloPassword(event) {
    const password = document.querySelector('.password input');

    if(password.value.length === 0) {
        document.querySelector('.password .error_printf').classList.remove('hidden');
    } else 
        document.querySelector('.password .error_printf').classList.add('hidden');
}

function onResponse(reponse) {
    if(reponse.ok)
        return reponse.json();
    else 
        null;
}

function jsonControlloEmail(json) {
    const mail = document.querySelector('.email input');

    if(!json.exists && mail.value.length > 0) {
        document.querySelector('.email .error_printf').classList.remove('hidden');
        document.querySelector('.email span').textContent="Nessuna email trovata.";
        document.querySelector('.email .registrati').classList.remove('hidden');
    } else if(mail.value.length === 0) {
        document.querySelector('.email .error_printf').classList.remove('hidden');
    }
}

function controlloEmail(event) {
    const mail = document.querySelector('.email input');

    fetch('verificaEmail.php?q='+encodeURIComponent(mail.value)).then(onResponse).then(jsonControlloEmail);
}

document.querySelector('.email input').addEventListener('blur', controlloEmail);
document.querySelector('.password input').addEventListener('blur', controlloPassword);