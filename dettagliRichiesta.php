<?php
    require_once 'verificaLogin.php';
    if(!$userid = checkAuth()) {
        header("Location: accesso.php");
    }
?>

<html>
    <?php
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id=$userid";
        $res_plus = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_plus);
    ?>
    <head>
        <link rel='stylesheet' href='dettagliRichiesta.css'>
        <script src='dettagliRichiesta.js' defer></script>

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
                    <img class='profileImg' src="utility/topolinoProfile.jpeg"/>
                </a>
            </div>
        </section>

        <section id="container-contenuto">
            <div class="generalInfo">
                <div id="copertina"></div>
                <div id="descrizione"></div>
            </div>
            <div class='preferiti'>
                <a>Aggiungi ai Preferiti</a>
                <img src="utility/cuore.png"/>
            </div>
            <div class="info">
            </div>
        </section>

        <div class='separatore'></div>
        <h1 class='recensioni'>Recensioni</h1>
        <section id="commentiInseriti"></section>
        
        <section id="commenti">
            <form autocomplete="off" name="formComment">
                <div class="inserisciCommento">
                    <label for="comment"></label>
                    <input type='text' name="comment" class="insertComment" placeholder="Inserisci Commento...">
                    <input type='submit' value='Invia'>
                </div>
            </form>
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