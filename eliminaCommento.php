<?php
    require_once "verificaLogin.php";
    if($userID = !checkAuth()) {
        exit;
    }

    $commentoID = urlencode($_GET['q']);

    $conn = mysqli_connect($dbconfig['root'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $query = "DELETE FROM commenti WHERE commentoID = '$commentoID'";


    mysqli_query($conn, $query);
    mysqli_close($conn);
?>