<?php
    require_once "verificaLogin.php";
    $userID = checkAuth();
    if(!$userID) {
        exit;
    }

    $contenutoID = urlencode($_GET['q']);
    $tipo = urlencode($_GET['t']);

    $conn = mysqli_connect($dbconfig['root'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $query = "INSERT INTO preferiti(id, contenutoID, tipo)values('$userID', '$contenutoID', '$tipo');";

    if ($conn->query($query) === TRUE) {
        echo json_encode(array('ok' => true));
    } else {
        echo "Errore durante l'inserimento: " . $conn->error;
    }

    mysqli_close($conn, $query);
?>