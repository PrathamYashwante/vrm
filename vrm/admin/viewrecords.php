<?php include_once '../main/header.php';

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}
?>
<style>
    .container {
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .card {
        margin-bottom: 20px;
    }

    form {
        display: block;
        margin-bottom: 10px;
    }

    label {
        margin-right: 10px;


    }

    input[type="date"] {
        width: 100%;
        margin-bottom: 10px;
    }

    button[type="submit"] {
        margin-left: 0;
    }

    .form-group-a {
        margin-bottom: 10px;

    }

    .form-group-a label {
        margin-right: 0;
        padding: 10px;
    }

    .form-group-a input {
        margin-right: 0;

        width: 100%;
        margin-bottom: 5px;
    }

    .form-group-a button {
        margin-left: 10px;
    }
</style>
<?php require_once '../database/dbh.inc.php'; ?>

<div class="container">
    <!-- Date Input Form -->
    <div class="card">
        <form method="POST" action="">
            <div class="form-group-a">
            <label for="dateInput">Date:</label>
            <input type="date" name="dateInput" id="dateInput" required>
            <button type="submit" name="submit">Get Data</button>
            </div>
        </form>
    </div>

    <?php
    // Retrieve all the table names in the database with their creation timestamps
    $tables = array();
    $query = "SELECT name_of_table, timestamp_of_table FROM table_timestamps";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $timestamps = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $tableName = $row['name_of_table'];
            $timestamp = $row['timestamp_of_table'];
            if ($tableName !== 'users' && substr($tableName, -3) !== '_pc' && substr($tableName, -3) !== '_sm') {
                $timestamps[$tableName] = $timestamp;
            }
        }

        // Sort the tables based on their creation time in ascending order
        asort($timestamps);
        $tables = array_keys($timestamps);
    } else {
        die("Error retrieving table names and timestamps: " . mysqli_error($conn));
    }

    // Step 2: Handle date input form submission
    if (isset($_POST['submit'])) {
        $dateInput = $_POST['dateInput'];

        // Step 3: Retrieve data for a particular table and date input
        $entries = array();
        foreach ($tables as $table) {
            // Skip tables ending with '_pc' and 'users' table
            if (substr($table, -3) === '_pc' || substr($table, -3) === '_sm' || $table === 'users') {
                continue;
            }

            $query = "SELECT * FROM $table WHERE ENTRY_DATE = '$dateInput'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $entries[$table][] = $row;
                    }
                } else {
                    $entries[$table] = array(); // No entries for this table
                }
            } else {
                die("Error retrieving data from table $table: " . mysqli_error($conn));
            }
        }

        // Display the entries
        if (!empty($entries)) {
            foreach ($entries as $table => $rows) {
                echo '<p></p>';
                echo "<div class='card'>";
               

                if (count($rows) > 0) {
                    echo "<p><strong>Table: $table</strong> | <a href=\"update_entry.php?table=$table&date=$dateInput\">Update</a></p>";
                    echo "<table class='table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Column</th>";
                    echo "<th>Value</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Display table rows
                    foreach ($rows as $rowIndex => $row) {
                        foreach ($row as $column => $value) {
                            echo "<tr>";
                            echo "<td>$column</td>";
                            echo "<td>$value</td>";
                            echo "</tr>";
                        }
                    }

                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "<p><strong>Table: $table</strong></p>";
                    echo "<p>No entries found for the given date.</p>";
                    echo "<p>Add entry:</p>";

                    echo "<div class='form-group-a'>";
                    echo "<form method='POST' action=''>";
                    echo "<input type='hidden' name='table' value='$table'>";
                    echo "<input type='hidden' name='dateInput' value='$dateInput'>";

                    // Retrieve columns for the table
                    $query = "SHOW COLUMNS FROM $table";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $column = $row['Field'];

                            // Exclude columns not required for entry
                            if ($column === 'ENTRY_DATE' || $column === 'ENTRY_TIME') {
                                continue;
                            }

                            echo "<div class='form-group-a'>";
                            echo "<label for='$column'>$column:</label>";
                            echo "<input type='text' name='$column' id='$column' required>";
                            echo "</div>";
                        }
                    } else {
                        die("Error retrieving columns from table $table: " . mysqli_error($conn));
                    }

                    echo "<br>";
                    echo "<button type='submit' name='addEntry'>Add Entry</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "<br>";
                }
                echo "</div>"; // End of card
            }
        } else {
            echo "<div class='container'><h3 class='card'>No tables found.</h3></div>";
        }
    }

    // Step 4: Handle add entry form submission
    if (isset($_POST['addEntry'])) {
        $table = $_POST['table'];
        $dateInput = $_POST['dateInput'];

        $columns = array();
        $values = array();

        // Retrieve columns for the table
        $query = "SHOW COLUMNS FROM $table";
        $result = mysqli_query($conn, $query);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $column = $row['Field'];

                // Exclude columns not required for entry
                if ($column === 'ENTRY_DATE' || $column === 'ENTRY_TIME') {
                    continue;
                }

                $columns[] = $column;
                $value = isset($_POST[$column]) ? $_POST[$column] : '';
                $values[] = "'$value'";
            }
        } else {
            die("Error retrieving columns from table $table: " . mysqli_error($conn));
        }

        $columnsString = implode(', ', $columns);
        $valuesString = implode(', ', $values);

        // Insert the entry into the table
        $query = "INSERT INTO $table ($columnsString, ENTRY_DATE) VALUES ($valuesString, '$dateInput')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script>alert('Entry added successfully.');</script>";
            echo "<script>window.location.href = '../admin/viewrecords.php';</script>";
        } else {
            echo "<script>alert('Error adding entry: " . mysqli_error($conn) . "');</script>";
        }
    }
    ?>

    <?php include_once '../main/footer.php'; ?>
</div>