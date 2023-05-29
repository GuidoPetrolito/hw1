fetch("topMovies.php").then(onResponse).then(topFilm);
fetch("topSerieTv.php").then(onResponse).then(topSerieTv);
fetch("filmUpcoming.php").then(onResponse).then(filmUpcoming);
fetch("serieTvUpcoming.php").then(onResponse).then(serieTvUpcoming);
fetch("SerieTvTopRated.php").then(onResponse).then(serieTvTopRated);
fetch("FilmTopRated.php").then(onResponse).then(FilmTopRated);

document.getElementById('container-contenuto').classList.remove('hidden');

function onResponse(response) {
    if(response.ok) {
        return response.json();
    } else return null;
}

//OTTENGO I MIGLIORI FILM
function topFilm(json) {
    const data = json;
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    let i = 0;

    const divsFilm = document.querySelectorAll('#topFilm .film');
    
    for(divFilm of divsFilm) {
        source_add = document.createElement('a');
        source_add.href='dettagliRichiesta.php';

        divFilm.dataset.id=data.results[i].id;
        divFilm.dataset.media_type=data.results[i].media_type;
        

        const image = document.createElement('img');
        image.src = url+data.results[i].poster_path;
        i++;
        divFilm.appendChild(source_add).appendChild(image);
        
        divFilm.addEventListener('click', getID);
    }
}

function getID(event) {
    div = event.currentTarget;
    fetch("richiestaRicerca.php?q="+encodeURIComponent(div.dataset.id)+"&t="+encodeURIComponent(div.dataset.media_type)).then(onResponseGetID);
}

function onResponseGetID(response) {

}

//OTTENGO LE MIGLIORI SERIE TV
function topSerieTv(json) {
    const data = json;
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    let i = 0;

    const divsSerieTv = document.querySelectorAll('#TopSerieTv .serieTv');

    for(let serieTv of divsSerieTv) {
        source_add = document.createElement('a');
        source_add.href='dettagliRichiesta.php';

        serieTv.dataset.id=data.results[i].id;
        serieTv.dataset.media_type=data.results[i].media_type;

        const image = document.createElement('img');
        image.src = url+data.results[i].poster_path;
        i++;

        serieTv.appendChild(source_add).appendChild(image);
        serieTv.addEventListener('click', getID);
    }
}

//OTTENGO I FILM IN ARRIVO
function filmUpcoming(json) {
    const data = json;
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    let i = 0;

    const divsFilm = document.querySelectorAll('#FilmIncoming .film');
    
    for(divFilm of divsFilm) {
        source_add = document.createElement('a');
        source_add.href='dettagliRichiesta.php';

        divFilm.dataset.id=data.results[i].id;
        divFilm.dataset.media_type='movie';

        image = document.createElement('img');
        image.src = url+data.results[i].poster_path;
        i++;
        divFilm.appendChild(source_add).appendChild(image);
        divFilm.addEventListener('click', getID);
    }
}

//OTTENGO LE SERIE TV IN ARRIVO
function serieTvUpcoming(json) {
    const data = json;
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    let i = 0;

    const SerieTvUp = document.querySelectorAll('div#SerieTvIncoming .serieTv');

    for(let serieTv of SerieTvUp) {
        source_add = document.createElement('a');
        source_add.href='dettagliRichiesta.php';

        const image = serieTv.querySelector('img');

        serieTv.dataset.id=data.results[i].id;
        serieTv.dataset.media_type='tv';

        if(json.results[i].poster_path != null) {
            image.src = url+data.results[i].poster_path;
        } else {
            i++
            image.src=url+data.results[i].poster_path;
        }

        i++;

        serieTv.appendChild(source_add).appendChild(image);
        serieTv.addEventListener('click', getID);
    }
}

//OTTENGO LE SERIE TV PIù VOTATE
function serieTvTopRated(json) {
    const data = json;
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    let i = 0;

    const SerieTvTR = document.querySelectorAll('div#SerieTvTopRated .serieTv');

    for(let serieTv of SerieTvTR) {
        source_add = document.createElement('a');
        source_add.href='dettagliRichiesta.php';
        
        let image = serieTv.querySelector('img');

        serieTv.dataset.id=data.results[i].id;
        serieTv.dataset.media_type='tv';

        image.src = url+data.results[i].poster_path;
        i++;


        serieTv.appendChild(source_add).appendChild(image);
        serieTv.addEventListener('click', getID);
    }
}

//OTTENGO I FILM PIù VOTATI
function FilmTopRated(json) {
    const data = json;
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    let i = 0;

    const divsFilm = document.querySelectorAll('#FilmTopRated .film');

    
    for(divFilm of divsFilm) {
        source_add = document.createElement('a');
        source_add.href='dettagliRichiesta.php';

        divFilm.dataset.id=data.results[i].id;
        divFilm.dataset.media_type='movie';

        image = document.createElement('img');
        image.src = url+data.results[i].poster_path;
        i++;

        divFilm.appendChild(source_add).appendChild(image);
        divFilm.addEventListener('click', getID);
    }
}

document.querySelector('.ricerca').addEventListener("submit", search);

function search(event) {
    event.preventDefault();

    const form_data = new FormData(document.querySelector("#container-ricerca form"));
    fetch("Ricerca.php?q="+encodeURIComponent(form_data.get('ricerca-contenuto'))).then(onResponse).then(jsonSearch);
}

function jsonSearch(json) {
    document.getElementById('container-contenuto').classList.add('hidden');
    document.getElementById('risultati_ricerca').classList.remove('hidden');
    const container = document.getElementById('risultati_ricerca');
    container.innerHTML = '';
    const url = 'https://www.themoviedb.org/t/p/w1280/';
    
    data = json.results;

    // RESTITUISCO I RISULTATI
    for(obj of data ) {
        if(obj.poster_path != undefined) {
            source_add = document.createElement('a');
            source_add.href='dettagliRichiesta.php';

            const divObj = document.createElement('div');
            divObj.dataset.image = url + obj.poster_path;

            const img = document.createElement('img');
            img.src = url + obj.poster_path;

            divObj.dataset.id=obj.id;
            divObj.dataset.media_type=obj.media_type;

            container.appendChild(divObj).appendChild(source_add).appendChild(img);
            divObj.addEventListener('click', getID);
        }
    }

    // PULSANTE RIPRISTINA HOME
    if(document.querySelector('#container-ricerca div') === null) {   
        const container_ricerca = document.getElementById('container-ricerca');
        const divCon = document.createElement('div');
        divCon.textContent = "Classifica";
        container_ricerca.appendChild(divCon);
    }

    document.querySelector('#container-ricerca div').addEventListener('click', onClick);
}

function onClick(event) {
    const input = document.querySelector('form .ricercaName');

    input.value = '';
    document.getElementById('container-contenuto').classList.remove('hidden');
    document.getElementById('risultati_ricerca').classList.add('hidden');
    document.querySelector('#container-ricerca div').remove();
}

// --------------------- CODICE PREFERITI ---------------------

fetch("ottieniPreferiti.php?").then(onResponse).then(onJsonPrefer);

function onResponse(Response) {
    if(Response.ok) 
    return Response.json();
    else null;
}

function onJsonPrefer(json) {
    let count = 0;

    for(obj of json) {
        if(obj[0].tipo === "film")
            fetch("dettagliFilm.php?q="+obj[0].contenutoID).then(onResponse).then(creazioneElemento);
        else
            fetch("RicercaDettagliSerieTv.php?q="+encodeURIComponent(obj[0].contenutoID)).then(onResponse).then(creazioneElemento);   
    }
}

function creazioneElemento(obj) {
    source_add = document.createElement('a');
    source_add.href='dettagliRichiesta.php';

    const container = document.getElementById('Preferiti');
    const url = 'https://www.themoviedb.org/t/p/w1280/';

    const divObj = document.createElement('div');

    const img = document.createElement('img');
    img.src = url + obj.poster_path;
    divObj.appendChild(img);

    divObj.dataset.id=obj.id;
    divObj.dataset.media_type=obj.media_type;

    divObj.appendChild(source_add).appendChild(img);

    container.appendChild(divObj);

    divObj.addEventListener('click', getID);
}

// ------------------ IMMAGINE PROFILO ICONA ------------------
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