<?php
    require_once 'verificaLogin.php';
    $id = checkAuth();
    
    if (!checkAuth()) {
        exit;
    }

    $contenutoID = urlencode($_GET['q']);
    $media_type = urldecode($_GET['t']);
    $dataOraCorrente = date('Y-m-d H:i:s');

    $error = array();
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    $date_att = date('Y-m-d H:i:s' , $timestamp);
    $query = "INSERT INTO ricercheRecenti(id, contenutoID, tstamp) VALUES ('$id', '$contenutoID', '$dataOraCorrente')";

    if($conn->connect_error) {
        echo "Connessione Fallita!";
    }
 
    $queryContenuto = "INSERT INTO FilmSerieTv(id, tipo_media) values ('$contenutoID', '$media_type')";

    $queryControlloEsistenzaFilm = "SELECT * FROM FilmSerieTv WHERE id='$contenutoID'";
    $res = mysqli_query($conn, $queryControlloEsistenzaFilm);

    
    if(!mysqli_num_rows($res) > 0) {
        mysqli_query($conn, $queryContenuto);
        mysqli_query($conn, $query);
    } else {
        mysqli_query($conn, $query);
    }
    
    mysqli_close($conn);
?>