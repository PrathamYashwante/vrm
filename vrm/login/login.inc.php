<?php

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $password = $_POST["pwd"];

    require_once '../database/dbh.inc.php';
    require_once 'login_functions.inc.php';

    if (emptyInputLogin($username, $password) !== False) {
        header("location: login.php?error=emptyinput");
        exit();
    }


    loginUser($conn, $username, $password);

} else {
    header("location: login.php");
    exit();
}
