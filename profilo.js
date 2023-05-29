document.querySelector('.containerImage img').addEventListener('click', clickOnImageDefault);

function clickOnImageDefault(event) {
    document.querySelector('.imageUp').classList.remove('hidden');
    images = document.querySelectorAll('.imageUp img');
    let count = 0;

    for(image of images) {
        image.addEventListener('click', updateImage);
        image.dataset.ID = count;
        count++;
    }
}

function updateImage(event) {
    const container = (event.currentTarget);
    image = container.src;
    const path = image.split("/").pop();

    document.querySelector('.imageUp').classList.add('hidden');
    document.querySelector('.containerImage img').src=image;

    fetch("updatePropic.php?q=imageProfile/"+decodeURIComponent(path));
}

fetch("getPropic.php").then(onReponse).then(propicAppend);

function onReponse(response) {
    if(response.ok)
        return response.json();
    else null;
}

function propicAppend(json) {
    const name = document.querySelector('.overlay h1');
    name.textContent = "Benvenuto " + json.username;
    document.querySelector('.overlay').appendChild(name);

    const path = (json.propic);

    (document.querySelector('.containerImage img')).remove();

    image = document.createElement('img');
    image.src = path;
    document.querySelector('.containerImage').appendChild(image);


    image.addEventListener('click', clickOnImageDefault);
}