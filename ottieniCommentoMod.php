<?php
require_once "verificaLogin.php";
$userID = checkAuth();

if ($userID === 0) {
    exit;
}

header("Content-Type: application/json");
$commentoID = urlencode($_GET['q']);

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

$commentoID = mysqli_real_escape_string($conn, $commentoID); // prevenire SQL injection

$query = "SELECT username, contenutoCommento, commentoID, id
FROM commenti JOIN users ON users.id = commenti.UserID
WHERE commentoID = '$commentoID'";

$res = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($res);
$row['contenutoCommento'] = urldecode($row['contenutoCommento']);
echo json_encode($row);
?>