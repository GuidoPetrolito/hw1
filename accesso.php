<?php
    // Verifica che l'utente sia già loggato, in caso positivo va direttamente alla home
    include 'verificaLogin.php';
    if (checkAuth()) {
        header('Location: home.php');
        exit;
    }

    if (!empty($_POST["email"]) && !empty($_POST["password"]) ) {
        // Se username e password sono stati inviati
        // Connessione al DB
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        // ID e Username per sessione, password per controllo
        $query = "SELECT * FROM users WHERE email = '".$email."'";
        // Esecuzione
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        
        if (mysqli_num_rows($res) > 0) {
            // Ritorna una sola riga, il che ci basta perché l'utente autenticato è solo uno
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {
                // Imposto una sessione dell'utente
                $_SESSION["email"] = $entry['email'];
                $_SESSION["user_id"] = $entry['id'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        // Se l'utente non è stato trovato o la password non ha passato la verifica
        $error = "Email e/o password errati.";
    } else if(empty($_POST["email"]) && !empty($_POST["password"])) {
        $error = "Inserisci l'Email.";
        // $error = $_POST["password"];
    } else if(empty($_POST["password"]) && !empty($_POST["email"])) {
        $error = "Inserisci la Password.";
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='accesso.css'>
        <script src='accesso.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>CineItalia - Accesso</title>
    </head>

    <body>
            <section class="header">
                <div class=sx>
                    <img id="imageWeb" src="utility/logoWeb.png"/>
                    <h1 id = "logo">CineItalia</h1>
                </div>
            </section>

            <section class="container-main">
                <form name="login" method="post">
                    <span class="access">Accedi</span><br>
                    <div class="email">
                        <label for="email"></label>
                        <input type="text" name="email" placeholder="Email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                        <div class='error_printf hidden'><img src="./utility/esclamazione.png"/><span>Inserisci l'indirizzo email.</span></div>
                    </div>

                    <div class="password">
                        <label for="password"></label>
                        <input type="password" name="password" placeholder="Password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        <div class='error_printf hidden'><img src="./utility/esclamazione.png"/><span>Inserisci la password.</span></div>
                    </div>

                    <div class="container-Accedi-Registrati">
                        <div class="submit">
                            <input type="submit" value="Accedi">
                        </div>
                        <span>Oppure</span><br>
                        <div class="registrazione">
                            <a href="registrazione.php"><button class="registrazione" type="button">Registrati</button></a>
                        </div>
                    </div>
                </form>
                <?php
                // Verifica la presenza di errori
                if(!empty($error)) {
                    echo "<div class='error_printf'><img src='./utility/esclamazione.png'/><span>".$error."</span></div>";
                }
                ?>
            </section>


            <footer>
                <div id="informazioni">
                    <span><a href=''>Chi Siamo</a></span>
                    <span><a href=''>Cosa Facciamo</a></span>
                    <span><a href=''>Termini e Condizioni</a></span>
                    <span><a href=''>Policy Privacy</a></span>
                    <span><a href=''>Crediti</a></span>
                    <span><a href=''>Contattaci</a></span>
                </div>
            </footer>
    </body>
</html>