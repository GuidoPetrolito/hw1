<?php
 require_once 'dbconfig.php';
 session_start();

 $var = ($_SESSION['user_id']);
 echo json_encode($var);
?>