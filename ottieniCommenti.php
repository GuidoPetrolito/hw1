<?php
require_once "verificaLogin.php";
$userID = checkAuth();

if($userID === 0) {
    exit;
}

header("Content-Type: application/json");
$contenutoID = urlencode($_GET['q']);

$conn = mysqli_connect($dbconfig['root'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

$query = "SELECT username, contenutoCommento, propic, commentoID, id
FROM commenti JOIN users ON users.id = commenti.UserID
WHERE idFilmSerieTv = '$contenutoID'";

$res = mysqli_query($conn, $query);

$resArray = array();

while($comment = mysqli_fetch_assoc($res)) {
    $resArray[] = array($comment);
}

$data = json_encode($resArray);

// Decodifica la stringa JSON in un array PHP
$array = json_decode($data, true);

// Array per i risultati
$result = [];

// Itera su ogni elemento dell'array
foreach ($array as $element) {
    // Accedi ai campi all'interno di ogni elemento
    $username = $element[0]['username'];
    $contenutoCommento = $element[0]['contenutoCommento'];
    $propic = $element[0]['propic'];
    $commentoID = $element[0]['commentoID'];
    $ID = $element[0]['id'];

    $contenutoCommento = urldecode($contenutoCommento);

    // Crea un array associativo per ogni elemento
    $assocArray = [
        'username' => $element[0]['username'],
        'contenutoCommento' => $contenutoCommento,
        'propic' => $element[0]['propic'],
        'commentoID' => $element[0]['commentoID'],
        'sessionID'=> $element[0]['id']
    ];

    // Aggiungi l'array associativo ai risultati
    $result[] = $assocArray;
}

$stamp = json_encode($result);
echo $stamp;
exit;
?>