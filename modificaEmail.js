
function jsonControlloEmail(json) {
    if(json.exists) {
        document.querySelector('.emailNuova span').innerHTML = '';
        const err = document.createElement('a');
        err.textContent = "Email non disponibile.";
        err.classList.add('error_printf');
        document.querySelector('.emailNuova span').appendChild(err);
        document.querySelector('.emailNuova .error_printf').classList.remove('hidden');
    } else  document.querySelector('.emailNuova .error_printf').classList.add('hidden');
}

function controlloEmail(event) {
    const input = document.querySelector('input#datoNuovo');
    fetch("verificaEmail.php?q="+encodeURIComponent(input.value)).then(onResponse).then(jsonControlloEmail);
}

function onResponse(response) {
    if(response.ok) {
        return response.json();
    } else null;
}

function controlloEmailConferma(event) {
    const confermaEmail = (event.currentTarget).value;   
    const email = document.querySelector('input#datoNuovo').value;

    if(confermaEmail != email) {
        document.querySelector('.confermaEmailNuova span').innerHTML = '';
        const err = document.createElement('a');
        err.textContent = "Le Email non coincidono.";
        err.classList.add('error_printf');
        document.querySelector('.confermaEmailNuova span').appendChild(err);
        document.querySelector('.confermaEmailNuova .error_printf').classList.remove('hidden');
    }
}

document.querySelector('input#datoNuovo').addEventListener('blur', controlloEmail);
document.querySelector('input#confermaDatoNuovo').addEventListener('blur', controlloEmailConferma);