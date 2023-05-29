<?php
require_once 'verificaLogin.php';
include 'disconnessione.php';
$userid = checkAuth();

if (!$userid) {
    header("Location: accesso.php");
    exit;
}

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']) or die(mysqli_error($conn));

$query = "DELETE FROM ricercheRecenti where id='$userid'";
mysqli_query($conn, $query);

$query = "DELETE FROM commenti where UserID='$userid'";
mysqli_query($conn, $query);

$query = "DELETE FROM preferiti where id='$userid'";
mysqli_query($conn, $query);

$query = "DELETE FROM users where id='$userid'";
mysqli_query($conn, $query);

mysqli_close($conn);
?>