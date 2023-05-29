let contenutoIDKey = null;

fetch("letturaRicercaRichiesta.php").then(onResponse).then(onJsonContenuto);

function onResponse(response) {
    if(response.ok) {
        return response.json();
    }
    else null;
}

//DOPO AVER OTTENUTO IL CODICE DEL FILM/SERIE TV ESEGUO LA FETCH PER CARICARE I DETTAGLI DEL FILM O DELLA SERIE TV
function onJsonContenuto(json) {
    
    for(ogg of json) {
        if(ogg[0].tipo_media === "movie") {
            contenutoIDKey=ogg[0].contenutoID;
            fetch("dettagliFilm.php?q="+encodeURIComponent(ogg[0].contenutoID)).then(onResponse).then(detailsFilm);
        }
        else {
            fetch("RicercaDettagliSerieTv.php?q="+encodeURIComponent(ogg[0].contenutoID)).then(onResponse).then(detailsSerieTv);
            contenutoIDKey=ogg[0].contenutoID;
        }
    }
}


function detailsSerieTv(json) {
    generalInfo = document.querySelector('.generalInfo');
    generalInfo.dataset.contenutoID = json.id;
    generalInfo.dataset.tipo="serieTv";

    const url = "https://www.themoviedb.org/t/p/w1280";

    container_image = document.querySelector('#copertina');
    const image = document.createElement('img');
    image.src = url+json.poster_path;
    container_image.appendChild(image);

    container_details = document.querySelector('#descrizione');
    const title = document.createElement('a');
    title.textContent = json.name;
    title.classList.add('title');
    
    const detail = document.createElement('p');
    detail.textContent = json.overview;
    detail.classList.add('detail');

    container_details.appendChild(title);
    container_details.appendChild(detail);

    infoPoint = document.querySelector('.Info');

    for(obj of json.seasons) {
        // QUESTO CONTIENE LA STAGIONE display flex colonna
        seasonNumber = document.createElement('div');
        seasonNumber.classList.add('seasonNumber');

        //QUESTO CONTIENE IMMGAINE E DELL STAGIONE display flex riga
        seasonNumberDivImage = document.createElement('DivImage');
        seasonNumberDivImage.classList.add('seasonNumberDivImage');

        seasonNumberImage = document.createElement('img');
        seasonNumberImage.classList.add('seasonNumberImage');
        seasonNumberImage.src=url+obj.poster_path;

        infoPoint.appendChild(seasonNumber).appendChild(seasonNumberDivImage).appendChild(seasonNumberImage);

        //CONTENITORE INFORMAZIONI TESTUALI
        const containerGenerale = document.createElement('div');
        containerGenerale.classList.add('containerGenerale');

        seasonNumber.appendChild(containerGenerale);

        const informazioniTextContainer = document.createElement('div');
        informazioniTextContainer.classList.add('informazioniTextContainer');

        containerGenerale.appendChild(informazioniTextContainer);

        const ContainerNumeroEpisodi = document.createElement('div');
        ContainerNumeroEpisodi.classList.add('ContainerNumeroEpisodi');

        const divImageEpisodi = document.createElement('div');
        divImageEpisodi.classList.add('divImageEpisodi');

        const imageEpisodi = document.createElement('img');
        imageEpisodi.classList.add('imageEpisodi');
        imageEpisodi.src='utility/episodio.png';

        containerGenerale.appendChild(informazioniTextContainer).appendChild(divImageEpisodi).appendChild(imageEpisodi);
        const numeroEpisodi = document.createElement('p');
        numeroEpisodi.textContent="Numero Episodi: " + obj.episode_count;
        informazioniTextContainer.appendChild(ContainerNumeroEpisodi).appendChild(numeroEpisodi);


        //CONTENITORE DETTAGLI STAGIONE
        const informazioniDettagliStagioneContainer = document.createElement('div');
        informazioniDettagliStagioneContainer.classList.add('informazioniDettagliStagioneContainer');

        const titleStagione = document.createElement('h1');
        titleStagione.textContent=obj.name;

        const descr = document.createElement('p');
        descr.textContent = obj.overview;

        containerGenerale.appendChild(informazioniDettagliStagioneContainer);
        informazioniDettagliStagioneContainer.appendChild(titleStagione);
        informazioniDettagliStagioneContainer.appendChild(descr);
    }

    fetch("ottieniCommenti.php?q="+encodeURIComponent(contenutoIDKey)).then(onResponse).then(jsonCommenti);

    fetch('ottieniPreferiti.php').then(onResponse).then(preferito);
}

function detailsFilm(json) {
    generalInfo = document.querySelector('.generalInfo');
    generalInfo.dataset.contenutoID = json.id;
    generalInfo.dataset.tipo="film";

    const url = "https://www.themoviedb.org/t/p/w1280";

    container_image = document.querySelector('#copertina');
    const image = document.createElement('img');
    image.src = url+json.poster_path;
    container_image.appendChild(image);

    container_details = document.querySelector('#descrizione');
    const title = document.createElement('a');
    title.textContent = json.title;
    title.classList.add('title');
    
    const detail = document.createElement('p');
    detail.textContent = json.overview;
    detail.classList.add('detail');

    container_details.appendChild(title);
    container_details.appendChild(detail);

    fetch("ottieniCommenti.php?q="+encodeURIComponent(contenutoIDKey)).then(onResponse).then(jsonCommenti);
    fetch('ottieniPreferiti.php').then(onResponse).then(preferito);
}



// ------------------- DA QUI INIZIA LA GESTIONE DEI COMMENTI ------------------- 

// PRENDO IL COMMENTO CHE HA INSERITO L'UTENTE E LO INOLTRO AL PHP PER INSERIRLO NEL DATABASE
document.querySelector('form').addEventListener('submit', commitComment);
function commitComment(event) {
    event.preventDefault();

    //leggo il tipo e il contenuto inserito e mando tutto alla pagina php
    const form_data = new FormData(document.querySelector('form'));

    //eseguo la fetch al php che si occupa di inserire il commento nel database
    fetch("inserimentoCommento.php?q="+encodeURIComponent(form_data.get('comment'))+"&k="+encodeURIComponent(contenutoIDKey)).then(onResponse).then(jsonCommentiLive);

    document.querySelector('input[type=text]').value = '';
} 

// PERMETTE DI AGGIORNARE LA PAGINA INSERENDO IL COMMENTO INVIATO 'LIVE' IN MANIERA 'ASINCRONA' SENZA REFRESHARE 
// LA PAGINA DELL'UTENTE
function jsonCommentiLive(json) {
    const container = document.querySelector('#commentiInseriti');

    const div = document.createElement('div');
    div.classList.add('commentiDiv');

    div.dataset.commentoID= json.commentoID;
    div.dataset.utenteID = json.sessionID;

    const user = document.createElement('h1');
    user.textContent = json.username;

    //CONT STA PER CONTENUTO COMMENTO
    const cont = document.createElement('p');
    cont.textContent = json.contenutoCommento;


    container.appendChild(div).appendChild(user).appendChild(cont);

    //PULSANTE ELIMINA
    const elimina = document.createElement('img');
    elimina.src='utility/elimina.png';
    div.appendChild(elimina);
    elimina.addEventListener('click', eliminaCommento);

    // PULSANTE MODIFICA
    const modifica = document.createElement('img');
    modifica.src='utility/modifica.png';
    div.appendChild(modifica);
    modifica.addEventListener('click', modificaCommento);
}


// SERVE PER OTTENERE I COMMENTI GIA' INSERITI IN PASSATO PER IL TITOLO CLICCATO
function jsonCommenti(json) {
    const container = document.querySelector('#commentiInseriti');
    container.innerHTML='';

    for(commento of json) {
        const div = document.createElement('div');

        div.dataset.sessionID = commento.sessionID;
        div.dataset.commentoID = commento.commentoID;

        div.classList.add('commentiDiv');

        const user = document.createElement('h1');
        user.textContent = commento.username;

        //CONT STA PER CONTENUTO COMMENTO
        const cont = document.createElement('p');
        cont.textContent = commento.contenutoCommento;

        container.appendChild(div).appendChild(user).appendChild(cont);
    }

    //DA QUI OTTENGO L'ID DELL'UTENTE LOGGATO
    fetch("controlloID.php").then(onResponse).then(controlloUserEliminaCommento);
}

let userID = null;

// MI GESTISCE LE AUTORIZZAZIONI DI CHI PUO' ELIMINARE IL COMMENTO, 
// OGNI UTENTE PUO' ELIMINARE SOLO I SUOI COMMENTI: RICHIEDO I COMMENTI DELL'UTENTE AL DATABASE MEDIANTE LA RICERCA
// PER USERDID OTTENUTA DA 'CONTROLLOID.PHP', CHE RESTITUIRE ID SESSION DELL'UTENTE
function controlloUserEliminaCommento(json) {
    userID = json;
    fetch("ottieniCommenti.php?q="+encodeURIComponent(contenutoIDKey)).then(onResponse).then(eliminaCommentoUp);

    fetch("ottieniCommenti.php?q="+encodeURIComponent(contenutoIDKey)).then(onResponse).then(modificaCommentoUp);
}

function eliminaCommentoUp(json) {
    totDiv = document.querySelectorAll('div.commentiDiv');

    let i = 0;
    for(obj of json) {
        if(obj.sessionID === userID) {
            if(totDiv[i].dataset.sessionID === userID) {
                const elimina = document.createElement('img');
                elimina.src='utility/elimina.png';
                totDiv[i].appendChild(elimina);
                elimina.addEventListener('click', eliminaCommento);
                i++;
            }
        } else {
            i++;
        }
    }
}

//ELIMINO IL COMMENTO
function eliminaCommento(event) {
    divClick = event.currentTarget;
    node = divClick.parentNode;

    // LO ELIMINO PRIMA DAL DATABASE
    fetch("eliminaCommento.php?q="+node.dataset.commentoID);

    // RICHIAMO LA FUNZIONE PER INSERIRE I COMMENTI CHE RIUTILIZZA LA FUNZIONE JS DI PRIMO CARICAMENTO, 
    // AGGIORNA I COMMENTI IN 'LIVE' AL CLICK, SENZA REFRESH DELLA PAGINA
    setTimeout(() =>
        fetch("ottieniCommenti.php?q=" + encodeURIComponent(contenutoIDKey)).then(onResponse).then(jsonCommenti),
        10
    );
}

// AGGIUNGO MODIFICA COMMENTO
function modificaCommentoUp(json) {
    totDiv = document.querySelectorAll('div.commentiDiv');

    let i = 0;
    for(obj of json) {
        if(obj.sessionID === userID) {
            if(totDiv[i].dataset.sessionID === userID) {
                const modifica = document.createElement('img');
                modifica.src='utility/modifica.png';
                totDiv[i].appendChild(modifica);
                modifica.addEventListener('click', modificaCommento);
                i++;
            }
        } else {
            i++;
        }
    }
}


// PRENDO IL COMMENTO DA MODIFICARE
function modificaCommento(event) {
    divClick = event.currentTarget;
    node = divClick.parentNode;


    // OTTENGO IL COMMENTO DA MODIFICARE
    fetch("ottieniCommentoMod.php?q="+node.dataset.commentoID).then(onResponse).then(CommentoOttenuto);
}

// PRIMA DI AGIRE SUL COMMENTO INSERISCO IL CONTENUTO DI QUESTO DENTRO IL FORM
function CommentoOttenuto(json) {
    document.querySelector('input.insertComment').value = json.contenutoCommento;
    fetch("eliminaCommento.php?q="+json.commentoID);

    // RICHIAMO LA FUNZIONE PER INSERIRE I COMMENTI CHE RIUTILIZZA LA FUNZIONE JS DI PRIMO CARICAMENTO, 
    // AGGIORNA I COMMENTI IN 'LIVE' AL CLICK, SENZA REFRESH DELLA PAGINA
    setTimeout(() =>
        fetch("ottieniCommenti.php?q=" + encodeURIComponent(contenutoIDKey)).then(onResponse).then(jsonCommenti),
        10
    );
}



// ------------------- DA QUI INIZIA LA GESTIONE DEI PREFERITI ------------------- 


// PRENDO IL CODICE DEL FILM CLICCATO DAL DIV [CONTIENE IL DATA-ATTRIBUTE 'CONTENUTOID'] ED
// ESEGUO L'INSERIMENTO NEL DATABASE
document.querySelector('div.preferiti').addEventListener('click', preferitoAdd);

// ALL'APERTURA DELLA PAGINA DEL TITOLO CON QUESTA FUNZIONE VERIFICO SUBITO AL CLICK SE GIA'
// E' AGGIUNTO, ALTRIMENTI SE NON LO E', TRAMITE IL CLICK ASSOCIATO A PREFERITOADD LO AGGIUNGO
function preferito(json) {
    const parentNodeOfDivCurrent = document.querySelector('.generalInfo');
    const contenutoID = parentNodeOfDivCurrent.dataset.contenutoID;

    for(obj of json) {
        if(obj[0].contenutoID === contenutoID) {
            document.querySelector('.preferiti img').src="utility/cuorePostAgg.webp";
            document.querySelector('.preferiti a').textContent="Rimuovi dai Preferiti";
            document.querySelector('div.preferiti').removeEventListener('click', preferitoAdd);
            document.querySelector('div.preferiti').addEventListener('click', removePreferito);
        }
    }
}

//RIMUOVO DAI PREFERITI
function removePreferito(event) {
    fetch("rimuoviPreferiti.php?q="+encodeURIComponent(contenutoIDKey));
    document.querySelector('.preferiti img').src="utility/cuore.png";
    document.querySelector('.preferiti a').textContent="Aggiungi ai Preferiti";


    document.querySelector('div.preferiti').removeEventListener('click', removePreferito);
    document.querySelector('div.preferiti').addEventListener('click', preferitoAdd);
}


// AGGIUNGO AI PREFERITI
function preferitoAdd(event) {
    divCurrent = event.currentTarget;
    parentNodeOfDivCurrent = divCurrent.parentNode;

    const contenutoID = parentNodeOfDivCurrent.querySelector('.generalInfo').dataset.contenutoID;
    const tipo = parentNodeOfDivCurrent.querySelector('.generalInfo').dataset.tipo;

    // SETTO IL DATA.ATTRIBUTE [PREFERORNOT] AD 1 SE VIENE AGGIUNTO AI PREFERITI
    // IN TAL MODO SE LO E', POSSO GESTIRE L'ELIMINAZIONE DAI PREFERITI
    document.querySelector('.preferiti').dataset.PreferOrNot = 1;
    document.querySelector('.preferiti img').src="utility/cuorePostAgg.webp";
    document.querySelector('.preferiti a').textContent="Rimuovi dai Preferiti";

    document.querySelector('div.preferiti').removeEventListener('click', preferitoAdd);
    document.querySelector('div.preferiti').addEventListener('click', removePreferito);

    fetch("inserimentoPreferiti.php?q="+contenutoID+"&t="+tipo);
}

// ----- PROPIC -----
fetch("getPropic.php").then(onReponse).then(propicAppend);

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