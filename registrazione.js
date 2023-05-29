function onResponse(response) {
    if(response.ok) {
        return response.json();
    }

    else {
        null;
    }
}

function controlloNome(event) {
    const input = event.currentTarget;
    if(form[input.name] = input.value.length > 0) {
        input.parentNode.classList.remove('error_printf');
    } else {
        input.parentNode.classList.add("error_printf");
    }
}

function controlloCognome(event) {
    const input = event.currentTarget;

    if(form[input.surname] = input.value.length > 0) {
        input.parentNode.classList.remove("error_printf");
    } else {
        input.parentNode.classList.add("error_printf");
    }
}

function jsonControlloNomeUtente(json) {
    if(form.username = !json.exists) {
        document.querySelector('.username').classList.remove('error_printf');
    } else {
        document.querySelector('.username span').textContent = "Nome utente già utilizzato.";
        document.querySelector('.username').classList.add('error_printf');
    }
}



function controlloNomeUtente(event) {
    const input = document.querySelector('.username input');

    fetch("verificaNomeUtente.php?q="+encodeURIComponent(input.value)).then(onResponse).then(jsonControlloNomeUtente);
}

function jsonControlloEmail(json) {
    if(form.email = !json.exists) {
        document.querySelector('.email').classList.remove('error_printf');
        document.querySelector('.email a').classList.add('hidden');
    } else {
        document.querySelector('.email a').classList.remove('hidden');
        document.querySelector('.email span').textContent = "Email già utilizzata.";
        document.querySelector('.email').classList.add('error_printf');
    }
}

function controlloEmail(event) {
    const input = document.querySelector('.email input');
    fetch("verificaEmail.php?q="+encodeURIComponent(input.value)).then(onResponse).then(jsonControlloEmail);
}

function controlloPassword(event) {
    const password = document.querySelector('.password input');

    if(form.password = password.value.length >= 8) {
        document.querySelector('.password').classList.remove('error_printf');
    } else {
        document.querySelector('.password').classList.add('error_printf');
    }
}

function controlloConfermaPassword(event) {
    const conferma_password = document.querySelector('.confirm_password input');

    if(form.password = conferma_password.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password').classList.remove('error_printf');
    } else {
        document.querySelector('.confirm_password').classList.add('error_printf');
    }
}

const form = document.querySelector('form');
document.querySelector('.name input').addEventListener('blur', controlloNome);
document.querySelector('.surname input').addEventListener('blur', controlloCognome);
document.querySelector('.username input').addEventListener('blur', controlloNomeUtente);
document.querySelector('.email input').addEventListener('blur', controlloEmail);
document.querySelector('.password input').addEventListener('blur', controlloPassword);
document.querySelector('.confirm_password input').addEventListener('blur', controlloConfermaPassword);