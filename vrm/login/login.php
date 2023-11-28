<?php include '../main/header.php' ?>
<style>
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
        <h2>Login</h2>
        <form action="login.inc.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="pwd" placeholder="Enter Password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo '<div class="alert alert-danger">
              <h4>Error</h4>
              <p>Fill in all details!</p>
            </div>';
        } else if ($_GET["error"] == "incorrectlogin") {
            echo '<div class="alert alert-danger">
              <h4>Error</h4>
              <p>Incorrect Login Credentials.</p>
            </div>';
        } else if ($_GET["error"] == "none") {
            echo '<div class="alert alert-info">

              <p>You have registered. Please Login.</p>
            </div>';
        }
    }
    ?>
</section>

<?php include_once '../main/footer.php' ?>