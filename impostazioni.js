// ------------- CARICO LA FOTO DEL PRIFLO ------------- 
fetch("getPropic.php").then(onReponse).then(propicAppend);
document.querySelector('.eliminaAccount').addEventListener('click', EliminaAccount);

function onReponse(response) {
    if(response.ok)
        return response.json();
    else null;
}

function propicAppend(json) {
    const path = (json.propic);

    document.querySelector('#profile img').remove();

    image = document.createElement('img');
    image.src = path;
    image.classList.add('profileImg');
    document.querySelector('#profile').appendChild(image);
}

// ------------- ELIMINA PROFILO ------------- 

function EliminaAccount(event) {
    const input = event.currentTarget;
    const divGenerale = document.querySelector('#container_opzioni');

    const divText = document.createElement('div');
    divText.classList.add('Text');
    const text = document.createElement('p');
    text.textContent = "L'azione è irreversibile, vuoi davvero eliminare definitivamente il tuo Account?";
    divGenerale.appendChild(divText).appendChild(text);

    divQuestion = document.createElement('div');
    divQuestion.classList.add('Question');
    const yes = document.createElement('a');
    yes.textContent = "Si";
    yes.dataset.value='yes';
    yes.href = "cancellaAccount.php";
    const no = document.createElement('a');
    no.textContent = "No";
    no.href="home.php";
    no.dataset.value='no';
    divGenerale.appendChild(divQuestion).appendChild(yes);
    divQuestion.appendChild(no);

    console.log(divGenerale);
}