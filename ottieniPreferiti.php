<?php
    require_once "verificaLogin.php";
    $userID = checkAuth();

    if(!$userID) {
        exit;
    }

    header("Content-Type: application/json");
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $query = "SELECT * FROM preferiti WHERE id='$userID'";
    $res = mysqli_query($conn, $query);

    $value = array();

    while($obj = mysqli_fetch_assoc($res)) {
        $value[] = array($obj);
    }

    echo json_encode($value);
?>