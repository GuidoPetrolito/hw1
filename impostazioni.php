<?php
    require_once 'verificaLogin.php';
    $userid = checkAuth();
    
    if(!$userid = checkAuth()) {
        header("Location: accesso.php");
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='impostazioni.css'>
        <script src='impostazioni.js' defer></script>

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
                <a id="profile" href="profilo.php">
                    <img class='profileImg' src="utility/loading.png"/>
                </a>
            </div>
        </section>

        <section id='container_opzioni'>
            <div class="modUsername" data-name='modUsername'><a href='modificaUsername.php'>Modifica Username</a></div>
            <div class="modEmail" data-name='modEmail'><a href='modificaEmail.php'>Modifica Email</a></div>
            <div class="modPassword" data-name='modPassword'><a href='modificaPassword.php'>Modifica Password</a></div>
            <div class="eliminaAccount" data-name='eliminaAccount'>Elimina Account</div>
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