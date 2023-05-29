
function jsonControlloEmail(json) {
    if(json.exists) {
        document.querySelector('.usernameNuovo span').innerHTML = '';
        const err = document.createElement('a');
        err.textContent = "Username non disponibile.";
        err.classList.add('error_printf');
        document.querySelector('.usernameNuovo span').appendChild(err);
        document.querySelector('.usernameNuovo .error_printf').classList.remove('hidden');
    } else  document.querySelector('.usernameNuovo .error_printf').classList.add('hidden');
}

function controlloEmail(event) {
    const input = document.querySelector('input#datoNuovo');
    fetch("verificaNomeUtente.php?q="+encodeURIComponent(input.value)).then(onResponse).then(jsonControlloEmail);
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
        document.querySelector('.confermaUsernameNuovo span').innerHTML = '';
        const err = document.createElement('a');
        err.textContent = "Gli Username non coincidono.";
        err.classList.add('error_printf');
        document.querySelector('.confermaUsernameNuovo span').appendChild(err);
        document.querySelector('.confermaUsernameNuovo .error_printf').classList.remove('hidden');
    }
}

document.querySelector('input#datoNuovo').addEventListener('blur', controlloEmail);
document.querySelector('input#confermaDatoNuovo').addEventListener('blur', controlloEmailConferma);