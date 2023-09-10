<?php
function normalize_input($data){
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "vergency";



?>