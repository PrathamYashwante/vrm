<?php

function emptyInputLogin($username, $password)
{

    if (empty($username) || empty($password)) {
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

function loginUser($conn, $username, $password)
{
    $userNameExists = usernameExists($conn, $username);

    if ($userNameExists === False) {
        header("location: login.php?error=incorrectlogin");
        exit();
    }

    $pwdhashed = $userNameExists["usersPassword"];
    $checkPwd = password_verify($password, $pwdhashed);

    if ($checkPwd === False) {
        header("location: login.php?error=incorrectlogin");
        exit();
    } else if ($checkPwd === True) {
        session_start();
        $_SESSION["usersID"] = $userNameExists["usersID"];
        $_SESSION["username"] = $userNameExists["usersUserName"];
        if (strpos($username, "admin") !== false) {
            header("location: ../main/home.php");
        } else {
            header("location: ../user/compiled.php");
        }
        exit();
    }
}
