<?php
    require_once 'verificaLogin.php';
    $userID = checkAuth();
    $commento = urlencode($_GET['q']);
    $contenutoID = urlencode($_GET['k']);
    $dataOraCorrente = date('Y-m-d H:i:s');

    if(!checkAuth()) {
        exit;
    }

    header("Content-Type: application/json");

    $conn = mysqli_connect($dbconfig['root'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));
    
    if($conn->connect_error) {
        echo "Connessione Fallita!";
    }
 
    $query = "INSERT INTO commenti(idFilmSerieTv, UserID, contenutoCommento, tstamp) values('$contenutoID', '$userID', '$commento', '$dataOraCorrente')";

    if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        $queryLast = "SELECT username, contenutoCommento, propic, commentoID, id
        FROM commenti JOIN users ON users.id = commenti.UserID
        WHERE contenutoCommento = '$commento'"; 

        $resLast = mysqli_query($conn, $queryLast);
        $last = mysqli_fetch_assoc($resLast);

        $last['contenutoCommento'] = urldecode($last['contenutoCommento']);
        echo json_encode($last);

        exit;
    };

    echo json_encode(array('ok' => false));
    mysqli_close($conn);
?>