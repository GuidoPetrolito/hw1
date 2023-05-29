<?php
    require_once 'verificaLogin.php';

    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }

    // Verifica l'esistenza di dati POST
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["name"]) &&
        !empty($_POST["surname"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"])) {
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

        # USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Cerco se l'username esiste già o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username già utilizzato";
            }
        }
        # PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "Caratteri password insufficienti";
        }
        # CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }
        # EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email già utilizzata. <a href='accesso.php'>Accedi.</a>";
            }
        }

        # REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $surname = mysqli_real_escape_string($conn, $_POST['surname']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, password, name, surname, email, propic) VALUES('$username', '$password', '$name', '$surname', '$email', 'utility/topolinoProfile.jpeg')";

            if (mysqli_query($conn, $query)) {
                $_SESSION["email"] = $_POST["email"];
                $_SESSION["user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    } else if(isset($_POST["username"])){
        $error = array("Compila tutti i campi");
    }
?>

<html>
    <head>
        <link rel='stylesheet' href='registrazione.css'>
        <script src='registrazione.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>CineItalia - Registrazione</title>
    </head>

        <body>
            <section class="header">
                <div class=sx>
                    <img id="imageWeb" src="utility/logoWeb.png"/>
                    <h1 id = "logo">CineItalia</h1>
                </div>

                <div id="accedi"><a href="accesso.php">Accedi</a></div>
            </section>

            <section class="container-main">
                <div class="container">
                    <h1>Accendiamo i riflettori sulla tua passione per il cinema: <br>registrati e sii il protagonista del nostro blog, senza effetti speciali!</h1>
                     <form name='registrazione' method='post' enctype="multipart/form-data" autocomplete="off">
                                <div class="names">
                                    <div class="name">
                                        <label for='name'></label>
                                        <input type='text' name='name' placeholder="Nome" <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                                        <div class='error'><img src="./utility/esclamazione.png"/><span>Devi inserire il tuo nome</span></div>
                                    </div>
                                    <div class="surname">
                                        <label for='surname'></label>
                                        <input type='text' name='surname' placeholder="Cognome" <?php if(isset($_POST["surname"])){echo "value=".$_POST["surname"];} ?> >
                                        <div class='error'><img src="./utility/esclamazione.png"/><span>Devi inserire il tuo cognome</span></div>
                                    </div>
                                </div>
                                <div class="username">
                                    <label for='username'></label>
                                    <input type='text' name='username' placeholder="Nome Utente" <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                                    <div class='error'><img src="./utility/esclamazione.png"/><span>Nome utente non disponibile</span></div>
                                </div>
                                <div class="email">
                                    <label for='email'></label>
                                    <input type='text' name='email' placeholder="Email" <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                                    <div class='error'><img src="./utility/esclamazione.png"/><span>Indirizzo email non valido.</span><a class="hidden" href='accesso.php'>Accedi.</a></div>
                                </div>
                                <div class="password">
                                    <label for='password'></label>
                                    <input type='password' name='password' placeholder="Password" <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                                    <div class='error'><img src="./utility/esclamazione.png"/><span>Inserisci almeno 8 caratteri</span></div>
                                </div>
                                <div class="confirm_password">
                                    <label for='confirm_password'></label>
                                    <input type='password' name='confirm_password' placeholder="Conferma Password" <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                                    <div class='error'><img src="./utility/esclamazione.png"/><span>Le password non coincidono</span></div>
                                </div>
                                <div class="allow">
                                    <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                                    <label for='allow'>Accetto i termini e condizioni d'uso.</label>
                                </div>

                                <div id="container_error">
                                    <?php if(isset($error)) {
                                            foreach($error as $err) {
                                                echo "<div class='error_printf'><img src='./utility/esclamazione.png'/><span>".$err."</span></div>";
                                            }
                                    } ?>
                                </div>

                                <div class="submit">
                                    <input type='submit' value="Registrati" id="submit">
                                </div>
                    </form>
                </div>

                <div id="presentazione">
                    <p>Pronto per una dose di cinema a portata di click? Crea il tuo profilo cinematografico personalizzato!<br>
                    Registrati al nostro blog di cinema e ottieni un accesso privilegiato a consigli personalizzati,<br>
                    liste di film consigliati in base ai tuoi gusti e la possibilità di condividere le tue recensioni con
                    una community di appassionati. <br>Unisciti a noi e crea la tua esperienza cinematografica su misura.</p>
                    <div class="container-content">
                        <div id="film">
                            <span>I Migliori Film</span>
                            <img src="utility/film.png"/>
                        </div>
                        <div id="serieTv">
                            <span>Le Migliori Serie TV</span>
                            <img src="utility/serietv.jpeg"/>
                        </div>
                    </div>
                </div> 

                <div id="dispositivi">
                    <p>Esplora il nostro blog di cinema!<br>
                    Dal tuo smartphone, tablet o computer, immergiti nel mondo del cinema con le nostre recensioni, news e approfondimenti.<br>
                    Siamo qui per alimentare la tua passione per il grande schermo, ovunque tu sia.</p>
                    <div class="container-dispositivi">
                        <div id="smartphone">
                            <span><h2>Smartphone</h2></span>
                            <img src="utility/cellulare.png"/>
                        </div>
                        <div id="tablet">
                            <span><h2 id='Mobile'>Tablet</h2></span>
                            <img src="utility/tablet.png"/>
                            <span><h2 id='notMobile'>Tablet</h2></span>
                        </div>
                        <div id="computer">
                            <span><h2>Computer</h2></span>
                            <img src="utility/computer.png"/>
                        </div>
                    </div>
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