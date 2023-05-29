<?php
require_once 'verificaLogin.php';
$userid = checkAuth();

if (!$userid) {
    header("Location: accesso.php");
    exit;
}

if (!empty($_POST['passwordAttuale']) && !empty($_POST['passwordNuova']) && !empty($_POST['confermaPasswordNuova'])) {
    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    # PASSWORD
    if (strlen($_POST["passwordNuova"]) < 8) {
        $error[] = "Caratteri password insufficienti";
    }
    # CONFERMA PASSWORD
    if (strcmp($_POST["confermaPasswordNuova"], $_POST["passwordNuova"]) != 0) {
        $error[] = "Le password non coincidono";
    }

    # CONTROLLO LA PASSWORD ATTUALE
    $queryControl = "SELECT password FROM users WHERE id='$userid'";
    $res = mysqli_query($conn, $queryControl);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $storedPassword = $row['password'];

        $passwordAttuale = mysqli_real_escape_string($conn, $_POST['passwordAttuale']);
        if (!password_verify($passwordAttuale, $storedPassword)) {
            $error[] = "Password attuale errata";
        }
    } else {
        $error[] = "Errore durante il controllo della password attuale";
    }

    if (count($error) === 0) {
        $password = mysqli_real_escape_string($conn, $_POST['confermaPasswordNuova']);
        $password = password_hash($password, PASSWORD_BCRYPT);

        $query = "UPDATE users SET password='$password' WHERE id='$userid'";
        mysqli_query($conn, $query);
        mysqli_close($conn);
        header("Location: home.php");
        exit; 
    }
} else if(isset($_POST['passwordAttuale'])) {
    $error = array("Compila tutti i campi");
}
?>


<html>
    <head>
        <link rel='stylesheet' href='modificaPassword.css'>
        <script src='modificaPassword.js' defer></script>

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
            <h1>Modifica Password</h1>
            <form name='processoMod'  method='post' enctype="multipart/form-data" autocomplete = "off">
                <div class="password">
                    <label for='passwordAttuale'></label>
                    <input type='password' name='passwordAttuale' id='datoAttuale' placeholder='Password Attuale'/>
                </div>

                <div class="passwordNuova">
                    <label for='passwordNuova'></label>
                    <input type='password' name='passwordNuova' id='datoNuovo' placeholder='Nuova Password'/>
                    <div class='error_printf hidden'><img src='./utility/esclamazione.png'/><span id='errore_password'></span></div>
                </div>

                <div class="confermaPasswordNuova">
                    <label for='confermaPasswordNuova'></label>
                    <input type='password' name='confermaPasswordNuova' id='confermaDatoNuovo' placeholder='Conferma Password'/>
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