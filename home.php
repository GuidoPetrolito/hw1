<?php
    require_once 'verificaLogin.php';
    if(!$userid = checkAuth()) {
        header("Location: accesso.php");
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='home.css'>
        <script src='home.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>CineItalia</title>
    </head>

    <body>
        <section class="header">
            <div class="sx">
                <img id="imageWeb" src="utility/logoWeb.png"/>
                <h1 id = "logo">CineItalia</h1>
            </div>

            <div class="dx">
                <a id="profile" href="profilo.php">
                    <img class='profileImg' src="utility/loading.png"/>
                </a>
            </div>
        </section>

        <section id="main">
            <section id="benvenuto">
                <div class="overlay">
                    
                <div id="textBenvenuto">
                    <p> Benvenuto al nostro blog cinematografico! <br>
                        Qui potrete trovare una vasta selezione di film, dalle ultime uscite ai classici imperdibili.<br>
                        Utilizzate la barra di ricerca per trovare facilmente i titoli che desiderate.<br>
                        Buona lettura e buon divertimento! </p>
                </div>

                <div id="container-ricerca"> 
                    <form autocomplete="off" class="ricerca">
                        <label for="ricerca-contenuto"></label>
                        <input type="text" name="ricerca-contenuto" class="ricercaName" placeholder="Inserisci il titolo">
                        <input type="submit" value="Cerca" class="ricercaSubmit">
                    </form>
                </div>
            </div>
            </section>

            <section id="container-contenuto" class="hidden">
            <div id="divFilm">
                    <span class="TextTop">I miei Preferiti</span>
                    <div id="Preferiti"></div>
                </div>

                <div id="divFilm">
                    <span class="TextTop">Film del Momento</span>
                    <div id="TopFilm">
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                    </div>
                </div>

                <div id="divSerieTv">
                    <span class="TextTop">Serie Tv del Momento</span>
                    <div id="TopSerieTv">
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                        <div class="serieTv"></div>
                    </div>
                </div>

                <div id="divFilm">
                    <span class="TextTop">Film più Votati</span>
                    <div id="FilmTopRated">
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                    </div>
                </div>

                <div id="divSerieTv">
                    <span class="TextTop">Serie Tv più Votate</span>
                    <div id="SerieTvTopRated">
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                    </div>
                </div>

                <div id="divFilm">
                    <span class="TextTop">Film in Arrivo</span>
                    <div id="FilmIncoming">
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                        <div class="film"></div>
                    </div>
                </div>

                <div id="divSerieTv">
                    <span class="TextTop">Serie Tv in Arrivo</span>
                    <div id="SerieTvIncoming">
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                        <div class="serieTv"><img src="cover/serietv/breakingbad.jpg"/></div>
                    </div>
                </div>
            </section>

            <section id="risultati_ricerca" class="hidden"></section>
        </section>

        <footer>
            <div id="informazioni">
                <span><a href=''>Chi Siamo</a></span>
                <span><a href=''>Cosa Facciamo</a></span>
                <span><a href="termini&condizioni.html">Termini e Condizioni</a></span>
                <span><a href=''>Policy Privacy</a></span>
                <span><a href=''>Crediti</a></span>
                <span><a href=''>Contattaci</a></span>
            </div>
        </footer>
    </body>
</html>