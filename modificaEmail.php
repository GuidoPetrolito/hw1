<?php
require_once 'verificaLogin.php';
$userid = checkAuth();

if (!$userid) {
    header("Location: accesso.php");
    exit;
}

if (!empty($_POST['emailNuova']) && !empty($_POST['confermaEmailNuova'])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $email = mysqli_real_escape_string($conn, strtolower($_POST['emailNuova']));
    $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($res) > 0) {
        $error[] = "Email già utilizzata.";
    }

    # CONFERMA EMAIL
    if (strcmp($_POST["emailNuova"], $_POST["confermaEmailNuova"]) != 0) {
        $error[] = "Le Email non coincidono";
    } 

    if (count($error) === 0) {
        $query = "UPDATE users SET email='$email' WHERE id='$userid'";
        mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: home.php");
        exit; 
    }
} else if(isset($_POST['emailNuova'])) {
    $error = array("Compila tutti i campi");
}
?>


<html>
    <head>
        <link rel='stylesheet' href='modificaEmail.css'>
        <script src="modificaEmail.js" defer></script>

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
            <h1>Modifica Email</h1>
            <form name='processoMod'  method='post' enctype="multipart/form-data" autocomplete = "off">
                <div class="emailNuova">
                    <label for='emailNuova'></label>
                    <input type='text' name='emailNuova' id='datoNuovo' placeholder='Nuova Email'/>
                    <div class='error_printf hidden'><img src='./utility/esclamazione.png'/><span></span></div>
                </div>

                <div class="confermaEmailNuova">
                    <label for='confermaEmailNuova'></label>
                    <input type='text' name='confermaEmailNuova' id='confermaDatoNuovo' placeholder='Conferma Email'/>
                    <div class='error_printf hidden'><img src='./utility/esclamazione.png'/><span></span></div>
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