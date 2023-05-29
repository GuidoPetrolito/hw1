fetch("ottieniPreferiti.php?").then(onResponse).then(onJsonPrefer);
MapKey = {};

function onResponse(Response) {
    if(Response.ok) 
    return Response.json();
    else null;
}

function onJsonPrefer(json) {
    let count = 0;

    for(obj of json) {
        if(obj[0].tipo === "film") {
            fetch("dettagliFilm.php?q="+obj[0].contenutoID).then(onResponse).then(creazioneElemento);
            MapKey[obj[0].contenutoID] = obj[0].tipo;
        }
        else {
            fetch("RicercaDettagliSerieTv.php?q="+encodeURIComponent(obj[0].contenutoID)).then(onResponse).then(creazioneElemento);  
            MapKey[obj[0].contenutoID] = obj[0].tipo;
        }
    }
}

function creazioneElemento(obj) {
    source_add = document.createElement('a');
    source_add.href='dettagliRichiesta.php';

    const container = document.getElementById('risultati_ricerca');
    const url = 'https://www.themoviedb.org/t/p/w1280/';

    const divObj = document.createElement('div');

    const img = document.createElement('img');
    img.src = url + obj.poster_path;
    divObj.appendChild(img);

    divObj.dataset.id=obj.id;
    divObj.dataset.media_type=obj.media_type;

    container.appendChild(divObj).appendChild(source_add).appendChild(img);
    divObj.addEventListener('click', getID);

    divObj.dataset.media_type=MapKey[obj.id];
}

function getID(event) {
    div = event.currentTarget;
    fetch("richiestaRicerca.php?q="+encodeURIComponent(div.dataset.id)+"&t="+encodeURIComponent(div.dataset.media_type)).then(onResponseGetID);
}



// ---- PROPIC ----
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