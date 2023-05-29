<?php
require_once 'verificaLogin.php';
$userid = checkAuth();

if (!$userid) {
    header("Location: accesso.php");
    exit;
}

if (!empty($_POST['usernameNuovo']) && !empty($_POST['confermaUsernameNuovo'])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $username = mysqli_real_escape_string($conn, strtolower($_POST['usernameNuovo']));
    $res = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if (mysqli_num_rows($res) > 0) {
        $error[] = "Username già utilizzato.";
    }

    # CONFERMA USERNAME
    if (strcmp($_POST["confermaUsernameNuovo"], $_POST["usernameNuovo"]) != 0) {
        $error[] = "Gli Username non coincidono";
    }

    if (count($error) === 0) {
        $query = "UPDATE users SET username='$username' WHERE id='$userid'";
        mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: home.php");
        exit; 
    }
} else if(isset($_POST['usernameNuovo'])) {
    $error = array("Compila tutti i campi");
}
?>


<html>
    <head>
        <link rel='stylesheet' href='modificaUsername.css'>
        <script src="modificaUsername.js" defer></script>

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

        <section class='processoMod'>
            <h1>Modifica Username</h1>
            <form name='processoMod'  method='post' enctype="multipart/form-data" autocomplete = "off">
                <div class="usernameNuovo">
                    <label for='usernameNuovo'></label>
                    <input type='text' name='usernameNuovo' id='datoNuovo' placeholder='Nuovo Username'/>
                    <div class='error_printf hidden'><img src='./utility/esclamazione.png'/><span id='errore_password'></span></div>
                </div>

                <div class="confermaUsernameNuovo">
                    <label for='confermaUsernameNuovo'></label>
                    <input type='text' name='confermaUsernameNuovo' id='confermaDatoNuovo' placeholder='Conferma Username'/>
                    <div class='error_printf hidden'><img src='./utility/esclamazione.png'/><span id='errore_password'></span></div>
                </div>

                <input type='submit' value='Conferma Modifica'/>
            </form>
            <div class='error'>
                <?php if(isset($error)) {
                        foreach($error as $err) {
                            echo "<div class='error_printf'><img src='./utility/esclamazione.png'/><span>".$err."</span></div>";
                        }
                } ?>
            </div>
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