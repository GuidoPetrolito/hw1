<?php
    require_once 'verificaLogin.php';
    require_once 'dbconfig.php';
    $userID = checkAuth();

    if (!checkAuth()) {
        exit;
    }

    $t = urlencode($_GET['t']);

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    
    if($conn->connect_error) {
        echo "Connessione Fallita!";
    }

    if($t == '1') {
        $query = "SELECT *
            FROM FilmSerieTv
            WHERE FilmSerieTv.id IN (
            SELECT DISTINCT FilmSerieTv.id
            FROM ricercheRecenti
            JOIN FilmSerieTv ON ricercheRecenti.contenutoID = FilmSerieTv.id
            WHERE ricercheRecenti.id = '$userID'
            GROUP BY FilmSerieTv.id, tstamp
            ORDER BY tstamp DESC
        );";
    } else {
        $query = "SELECT * 
        FROM ricercheRecenti JOIN FilmSerieTv ON ricercheRecenti.contenutoID=FilmSerieTv.id
        WHERE ricercheRecenti.id='$userID' 
        GROUP BY tstamp DESC
        LIMIT 1";
    }

    $res = mysqli_query($conn, $query);

    
    $resContenuto = array();
    while($entry = mysqli_fetch_assoc($res)) {
        $resContenuto[] = array($entry);
    }

    echo json_encode($resContenuto);
    mysqli_close($conn);
?>