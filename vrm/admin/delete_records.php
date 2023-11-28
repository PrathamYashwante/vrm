<?php include_once '../main/header.php'; 

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}
?>

<?php

require_once '../database/dbh.inc.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $date = isset($_POST['date']) ? $_POST['date'] : '';

    // Check if the date is provided
    if (!empty($date)) {
        // Delete records for the specified date from all tables except 'users'
        $tables = array(); // Array to store the table names

        // Retrieve all table names from the database
        $query = "SHOW TABLES";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Extract the table names and store them in the $tables array
            while ($row = mysqli_fetch_row($result)) {
                $tableName = $row[0];
                if ($tableName !== 'users' && $tableName !== 'table_timestamps') { // Exclude 'users' and 'time_staps' table
                    $tables[] = $tableName;
                }
            }

            // Iterate through each table and delete records for the specified date
            foreach ($tables as $table) {

                $query = "DELETE FROM $table WHERE ENTRY_DATE = ?";

                // Create a prepared statement
                $stmt = mysqli_stmt_init($conn);
                if (mysqli_stmt_prepare($stmt, $query)) {
        
                    mysqli_stmt_bind_param($stmt, "s", $date);


                    if (mysqli_stmt_execute($stmt)) {
                        $numDeletedRows = mysqli_stmt_affected_rows($stmt);
                        $message = "Deleted $numDeletedRows record(s) for the date $date from table '$table'.";
                    } else {
                        $error = "Error executing the delete statement for table '$table': " . mysqli_stmt_error($stmt);
                        break; 
                    }


                    mysqli_stmt_close($stmt);
                } else {
                    $error = "Error preparing the delete statement for table '$table': " . mysqli_error($conn);
                    break; 
                }
            }


            if (!isset($error)) {
                $message = "Deleted records for the date $date from all tables.";
            }
        } else {
            $error = "Error retrieving table names: " . mysqli_error($conn);
        }
    } else {
        $error = "Please provide a valid date.";
    }
}
?>

<div class="container">
    <div class="card">
        <h2>Delete Records by Date:</h2>

        <?php if (isset($message)) : ?>
            <div class="alert alert-success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>
            <button type="submit">Delete Records</button>
        </form>
    </div>
</div>