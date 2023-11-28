<?php


function emptyInputRegister($fullname, $username, $password)
{
    if (empty($fullname) || empty($username) || empty($password)) {
        $result = True;
    } else {
        $result = False;
    }
    return $result;
}

function invalidUsername($username)
{
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = True;
    } else {
        $result = False;
    }
    return $result;
}


function usernameExists($conn, $username)
{

    $sql = "SELECT * FROM users WHERE usersUserName = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: register.php?error=statementfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        mysqli_stmt_close($stmt);
        $result = false;
        return $result;
    }
}

function createUser($conn, $fullname, $username, $password)
{
    $sql = "INSERT INTO users (usersFullName, usersUserName, usersPassword) 
    Values (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: register.php?error=statementfailed");
        exit();
    }

    $hashedpwd = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $fullname, $username, $hashedpwd);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    header("location: ../login/login.php?error=none");
    exit();
}
