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
</style>
<?php require_once '../database/dbh.inc.php'; ?>

<div class="container">
    <!-- Date Input Form -->
    <div class="card">
        <form method="POST" action="">
            <label for="dateInput">Date:</label>
            <input type="date" name="dateInput" id="dateInput" required>
            <button type="submit" name="submit">Get Data</button>
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

    // Handle date input form submission
    if (isset($_POST['submit'])) {
        $dateInput = $_POST['dateInput'];

        // Retrieve data for a particular table and date input
        $entries = array();
        foreach ($tables as $table) {
            // Skip tables ending with '_pc' and 'users' table
            if (substr($table, -3) === '_pc' || substr($table, -3) === '_sm' || $table === 'users') {
                continue;
            }

            // Calculate previous date
            $previousDate = date('Y-m-d', strtotime($dateInput . ' -1 day'));


            // Get previous date
            $previousDateQuery = "SELECT * FROM $table WHERE ENTRY_DATE = '$previousDate'";
            $previousDateResult = mysqli_query($conn, $previousDateQuery);
            $previousDate = mysqli_fetch_assoc($previousDateResult)['ENTRY_DATE'] ?? '';

            // Get previous readings
            $previousReadings = array();
            if ($previousDate != '') {
                $previousReadingsQuery = "SELECT * FROM $table WHERE ENTRY_DATE = '$previousDate'";
                $previousReadingsResult = mysqli_query($conn, $previousReadingsQuery);
                if ($previousReadingsResult && mysqli_num_rows($previousReadingsResult) > 0) {
                    $previousReadings = mysqli_fetch_assoc($previousReadingsResult);
                }
            }

            // Get current readings
            $currentReadingsQuery = "SELECT * FROM $table WHERE ENTRY_DATE = '$dateInput'";
            $currentReadingsResult = mysqli_query($conn, $currentReadingsQuery);

            if ($currentReadingsResult) {
                if (mysqli_num_rows($currentReadingsResult) > 0) {
                    $currentReadings = mysqli_fetch_assoc($currentReadingsResult);
                    $entries[$table] = array(
                        'previous' => $previousReadings,
                        'current' => $currentReadings
                    );
                } else {
                    $entries[$table] = array(
                        'previous' => $previousReadings,
                        'current' => array()
                    );
                }
            } else {
                die("Error retrieving data from table $table: " . mysqli_error($conn));
            }
        }

        // Display the entries
        if (!empty($entries)) {
            foreach ($entries as $table => $data) {
                echo '<p></p>';
                echo "<div class='card'>";
                echo "<p><strong>Table: $table</strong></p>";
                echo "<table class='table'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Column</th>";
                echo "<th>Previous Reading</th>";
                echo "<th>Current Reading</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                foreach ($data['current'] as $column => $value) {
                    echo "<tr>";
                    echo "<td>$column</td>";
                    echo "<td>";
                    if (isset($data['previous'][$column])) {
                        echo $data['previous'][$column];
                    } else {
                        echo "0";
                    }
                    echo "</td>";
                    echo "<td>$value</td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>"; // End of card
            }
        } else {
            echo "<div class='container'><h3 class='card'>No tables found.</h3></div>";
        }
    }
    ?>

    <?php include_once '../main/footer.php'; ?>
</div>