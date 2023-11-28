<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>VRM Data Management</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body,
        h1,
        h2,
        h3,
        p,
        label,
        input,
        button {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 16px;
            background-color: #0c4c66;

        }

        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
            display: inline-block;
        }

        input[type="text"],
        input[type="date"],
        input[type="password"],
        input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 70%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        input[type="date"] {
            width: auto;
        }

        button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .card {
            margin: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-h3 {
            margin: 10px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        img {
            width: 70px;
            height: 70px;
            padding: 5px;
        }

        .navbar {
            background-color: #0c4c66;
            display: flex;
            align-items: center;
        }

        .navbar .navbar-nav {
            display: flex;
            align-items: center;
            list-style-type: none;
        }

        .navbar .navbar-nav .nav-item {
            margin-right: 10px;
        }

        .navbar .navbar-nav .nav-link {
            color: #fff;
            display: flex;
            align-items: center;
            font-size: 20px;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #fbc531;
        }

        .navbar .navbar-nav .active>.nav-link {
            color: #fbc531;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <ul class="navbar-nav">

            <img src="../images/logo.jpg" alt="JSW Cement Logo">
            <li class="nav-item">
                <a class="nav-link" href="../user/compiled.php">Home</a>
            </li>

            <?php

            if (isset($_SESSION["username"])) {
                if (strpos($_SESSION["username"], "admin") !== false) {
      echo '<li class="nav-item"><a class="nav-link" href="../logout/logout.inc.php">Logout</a></li>';
                } else {

         echo '<li class="nav-item"><a class="nav-link" href="../logout/logout.inc.php">Logout</a></li>';
                }
            } else {
                echo '<li class="nav-item"><a class="nav-link" href="../login/login.php">Login</a></li>';
                echo '<li class="nav-item"><a class="nav-link" href="../register/register.php">Register</a></li>';
            }

            ?>
        </ul>
    </nav>