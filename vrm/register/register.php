<?php
include_once '../main/header.php'
?>
<style>
    .card {
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        text-align: center;
    }

    .form-group {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    button {
        width: 80%;
    }
</style>

<section class="container">
    <div class="card">
        <h2>Register</h2>
        <form action="register.inc.php" method="post">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter Full Name" required class="input-field">
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required class="input-field">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="pwd" placeholder="Enter Password" required class="input-field">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Register</button>
        </form>
    </div>


    <?php

    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "Fill in all details!";
        } else if ($_GET["error"] == "invalidusername") {
            echo "Username is Invalid! Please user characters such as a-z or A-Z or 0-9 only.";
        } else if ($_GET["error"] == "usernamealreadyexists") {
            echo "Username Exists! Register with a different username.";
        } else if ($_GET["error"] == "statementfailed") {
            echo "Invalid Inputs.... SQL Statement Failed! Input Correct Details.";
        } else if ($_GET["error"] == "none") {
            echo "You have registered. Please Login.";
        }
    }

    ?>
</section>

<?php
include_once '../main/footer.php'
?>