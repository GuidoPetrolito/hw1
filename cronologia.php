<?php
    require_once 'verificaLogin.php';
    if(!$userid = checkAuth()) {
        header("Location: accesso.php");
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='cronologia.css'>
        <script src='cronologia.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>CineItalia</title>
    </head>

    <body>
    <section class="header">
                <div class="sx">
                    <img id="imageWeb" src="utility/logoWeb.png"/>
                    <a href="home.php"><h1 id = "logo">CineItalia</h1></a>
                </div>

                <div class="dx">
                    <a id="profile" href="home.php">
                        <img class='profileImg' src="utility/topolinoProfile.jpeg"/>
                    </a>
                </div>
        </section>

        <section id='risultati_ricerca'></section>


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