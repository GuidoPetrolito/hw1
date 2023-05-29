<?php
    require_once 'verificaLogin.php';
    if(!$userid = checkAuth()) {
        header("Location: accesso.php");
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='profilo.css'>
        <script src='profilo.js' defer></script>

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
        </section>

        <section id='container_profilo'>
            <div class="overlay">
                <div class="containerImage">
                    <img class='defualt' src="imageProfile/topolinoProfile.jpeg" />
                </div>
                <h1></h1>
            </div>
        </section>

        <div class="imageUp hidden">
            <img src="imageProfile/topolino1.jpeg" />
            <img src="imageProfile/topolino2.jpeg" />
            <img src="imageProfile/topolino3.jpeg" />
            <img src="imageProfile/topolino4.jpeg" />
            <img src="imageProfile/topolino5.jpeg" />

            <img src="imageProfile/winnie1.jpeg" />
            <img src="imageProfile/winnie2.jpeg" />
            <img src="imageProfile/winnie3.jpeg" />
            <img src="imageProfile/winnie4.jpeg" />
            <img src="imageProfile/winnie5.jpeg" />


            <img src="imageProfile/lilo1.jpeg" />
            <img src="imageProfile/lilo2.jpeg" />
            <img src="imageProfile/lilo3.jpeg" />
            <img src="imageProfile/lilo4.jpeg" />
            <img src="imageProfile/lilo5.jpeg" />
        </div>

        <section id='container_opzioni'>
            <div class="preferiti"><a href="preferitiPage.php">Contenuti Preferiti</a></div>
            <div class="cronologia"><a href="cronologia.php">Cronologia Navigazione</a></div>
            <div class="impostazioni"><a href="impostazioni.php">Impostazioni Account</a></div>
            <div class="logout"><a href="disconnessione.php">Logout</a></div>
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
