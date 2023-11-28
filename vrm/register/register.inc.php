<?php

if (isset($_POST["submit"])) {

    $fullname = $_POST["fullname"];
    $username = $_POST["username"];
    $password = $_POST["pwd"];

    require_once '../database/dbh.inc.php';
    require_once 'register_functions.inc.php';

    if (emptyInputRegister($fullname, $username, $password) !== False) {
        header("location: register.php?error=emptyinput");
        exit();
    }

    if (invalidUsername($username) !== False) {
        header("location: register.php?error=invalidusername");
        exit();
    }


    if (usernameExists($conn, $username) !== False) {
        header("location: register.php?error=usernamealreadyexists");
        exit();
    }

    createUser($conn, $fullname, $username, $password);
} else {
    header("location: register.php");
    exit();
}
