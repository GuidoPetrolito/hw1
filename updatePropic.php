<?php
    require_once "verificaLogin.php";
    $userID = checkAuth();
    if(!$userID) {
        exit;
    }

    header('Content-Type: application/json');
    $newPropic = urldecode($_GET['q']);

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

    $newPropic = mysqli_real_escape_string($conn, $newPropic); // Evita l'SQL injection

    $query = "UPDATE users SET propic = '$newPropic' WHERE id = '$userID'";
    mysqli_query($conn, $query);
    mysqli_close($conn);
?>
