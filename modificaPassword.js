
function controlloPassword(event) {
    const password = document.querySelector('input#datoNuovo');

    if(password.value.length < 8) {
        document.querySelector('.passwordNuova span').innerHTML = '';
        const err = document.createElement('a');
        err.textContent = "Errore: lunghezza minima 8 caratteri.";
        err.classList.add('error_printf');
        document.querySelector('.passwordNuova span').appendChild(err);
        document.querySelector('.passwordNuova .error_printf').classList.remove('hidden');
    } else  document.querySelector('.passwordNuova .error_printf').classList.add('hidden');
}

function controlloConfermaPassword(event) {
    const password = document.querySelector('input#datoNuovo').value;
    const confermaPassword = document.querySelector('input#confermaDatoNuovo').value;

    if(password != confermaPassword) {
        document.querySelector('.confermaPasswordNuova span').innerHTML = '';
        const err = document.createElement('a');
        err.textContent = "Le Password non coincidono!";
        err.classList.add('error_printf');
        document.querySelector('.confermaPasswordNuova span').appendChild(err);
        document.querySelector('.confermaPasswordNuova .error_printf').classList.remove('hidden');
    } else  document.querySelector('.confermaPasswordNuova .error_printf').classList.add('hidden');
}

const form = document.querySelector('form');
form.querySelector('input#datoNuovo').addEventListener('blur', controlloPassword);
form.querySelector('input#confermaDatoNuovo').addEventListener('blur', controlloConfermaPassword);