<?php
    require_once "verificaLogin.php";
    $userID = checkAuth();
    if(!$userID) {
        exit;
    }

    header('Content-Type: application/json');

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $queryRichiesta = "SELECT propic, username FROM users WHERE id='$userID'";
    $res = mysqli_query($conn, $queryRichiesta);
    $resFetch = mysqli_fetch_assoc($res); 
    echo json_encode($resFetch);

    mysqli_close($conn);
?>
