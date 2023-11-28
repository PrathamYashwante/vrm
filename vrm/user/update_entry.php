<?php include_once '../main/header copy.php'; 

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}
?>
<?php
// update_entry.php


if (isset($_GET['table']) && isset($_GET['date'])) {
    $table = $_GET['table'];
    $date = $_GET['date'];

    // Process the form submission
    if (isset($_POST['submit'])) {
        // Retrieve the updated values
        $updatedValues = $_POST['values'];

        // Update the entries in the database
        require_once '../database/dbh.inc.php';

        foreach ($updatedValues as $column => $value) {


            // Update the entry in the table
            $query = "UPDATE $table SET $column = '$value' WHERE ENTRY_DATE = '$date'";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die("Error updating entry: " . mysqli_error($conn));
            }
        }
        echo "<div class='container'><h3 class='card'>Data updated successfully into the tables. Go to <a href='../user/viewrecords.php'>View Records Page</a></h3></div>";
    }

    // Retrieve the entry from the database for the given table and date
    require_once '../database/dbh.inc.php';

    $entry = array();
    $query = "SELECT * FROM $table WHERE ENTRY_DATE = '$date'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $entry = mysqli_fetch_assoc($result);
    } else {
        die("Error retrieving entry: " . mysqli_error($conn));
    }
} else {
}
?>
<div class="card">
    <!-- Update Entry Form -->
    <h2>Update Entry for Table: <?php echo $table; ?></h2>
    <h3>Date: <?php echo $date; ?></h3>

    <form method="POST" action="">
        <?php foreach ($entry as $column => $value) { ?>
            <label for="<?php echo $column; ?>"><?php echo $column; ?>:</label>
            <input type="text" name="values[<?php echo $column; ?>]" id="<?php echo $column; ?>" value="<?php echo $value; ?>">
            <br>
        <?php } ?>

        <button type="submit" name="submit" value="Update">Update Values</button>
    </form>
</div>
<?php
include_once '../main/footer.php'
?>