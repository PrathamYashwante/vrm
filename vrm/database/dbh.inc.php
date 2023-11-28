<?php

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "vrm";


$conn = mysqli_connect(
    $serverName,
    $dbUsername,
    $dbPassword,
    $dbName
);

if (!$conn) {
    die("Connection unsuccessfull. Error: " . mysqli_connect_error());
} else {
    
}
