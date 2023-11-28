<?php include_once '../main/header copy.php';

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}
?>


<style>
    .output-table {
        width: 100%;
        border-collapse: collapse;
    }

    .output-table thead {
        background-color: #f8f9fa;
    }

    .output-table th,
    .output-table td {
        padding: 10px;
        border: 1px solid #ccc;
    }

    .output-table th {
        font-weight: bold;
    }
</style>
<?php
require_once '../database/dbh.inc.php';



// Retrieve all the table names in the database with their creation timestamps
$tables = array();
$query = "SELECT name_of_table, timestamp_of_table FROM table_timestamps";
$result = mysqli_query($conn, $query);

if ($result) {
    $timestamps = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tableName = $row['name_of_table'];
        $timestamp = $row['timestamp_of_table'];
        $timestamps[$tableName] = $timestamp;
    }

    // Sort the tables based on their creation time in ascending order
    asort($timestamps);
    $tables = array_keys($timestamps);
} else {
    die("Error retrieving table names and timestamps: " . mysqli_error($conn));
}


// Fetch column names for each table and store in a dictionary
$tableColumns = array();
foreach ($tables as $table) {
    $query = "SHOW COLUMNS FROM $table";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $columnNames = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $columnNames[] = $row['Field'];
        }
        $tableColumns[$table] = $columnNames;
    } else {
        die("Error retrieving column names for table $table: " . mysqli_error($conn));
    }
}

// Step 2: Handle date input form submission
if (isset($_POST['submit'])) {
    $dateInput = $_POST['dateInput'];

    // Step 3: Retrieve data for a particular table and date input
    $output = array();
    foreach ($tables as $table) {
        // Skip tables ending with '_pc' and 'users' table
        if (substr($table, -3) === '_pc' || substr($table, -3) === '_sm' || $table === 'users') {
            continue;
        }

        // 3a. Get date input entries of all columns
        $query = "SELECT * FROM $table WHERE ENTRY_DATE = '$dateInput'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $dateInputEntries = mysqli_fetch_assoc($result);
        } else {
            echo "<div class='container'>";
            echo "<h3 class='card'>Error retrieving meter reading entries for table $table for date $dateInput" . mysqli_error($conn) . "</h3>";
            echo "</div>";
            die();
        }

        // 3b. Get previous date input entries of all columns
        $previousDate = date('Y-m-d', strtotime($dateInput . ' -1 day'));
        $query = "SELECT * FROM $table WHERE ENTRY_DATE = '$previousDate'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $previousDateEntries = mysqli_fetch_assoc($result);
        } else {
            // Use previous values as 0
            $previousDateEntries = array();
            foreach ($dateInputEntries as $column => $value) {
                if ($column !== 'ENTRY_DATE') {
                    $previousDateEntries[$column] = 0;
                }
            }
        }

        // Check if any value is less than 10 for the current date
        $isLessThan10 = false;
        foreach ($dateInputEntries as $column => $value) {
            if ($column !== 'ENTRY_DATE' && $value < 10) {
                $isLessThan10 = true;
                break;
            }
        }

        if ($isLessThan10) {
            // Set all differences to 0
            foreach ($dateInputEntries as $column => $value) {
                if ($column !== 'ENTRY_DATE') {
                    $output[$table][$column] = 0;
                }
            }
        } else {
            // Subtract both the entries and store in the output array
            foreach ($dateInputEntries as $column => $value) {
                if ($column !== 'ENTRY_DATE') {
                    $previousValue = $previousDateEntries[$column];
                    $difference = abs($value - $previousValue);
                    $output[$table][$column] = $difference;
                }
            }
        }
    }

    // Display the output
    foreach ($output as $table => $columns) {
        echo "<div class='container'>";
        echo "<div class='card'>";
        echo "<h4><strong>Table: $table</strong></h4>";
        echo "<table class='output-table'>";
        echo "<thead><tr><th>Column</th><th>Power Consumption</th></tr></thead>";
        echo "<tbody>";
        foreach ($columns as $column => $difference) {
            echo "<tr>";
            echo "<td>$column</td>";
            echo "<td>$difference</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    }

    // Step 4: Store output in corresponding tables with _pc suffix
    foreach ($output as $table => $columns) {
        $pcTable = $table . '_pc';

        // Check if _pc table already exists if not create it
        $query = "SHOW TABLES LIKE '$pcTable'";
        $result = mysqli_query($conn, $query);

        if (!$result || mysqli_num_rows($result) === 0) {
            $createTableQuery = "CREATE TABLE $pcTable LIKE $table";
            mysqli_query($conn, $createTableQuery);
        }


        // Calculate SUBTOTAL for the current table
        $SUBTOTAL = array_sum($columns); // Exclude the ENTRY_DATE column from the SUBTOTAL calculation
        $columns['SUBTOTAL'] = $SUBTOTAL; // Add the SUBTOTAL to the columns array

        // Generate the column-value pairs for the update statement
        $updatePairs = array();
        foreach ($columns as $column => $difference) {
            $updatePairs[] = "$column = $difference";
        }
        $updatePairsString = implode(', ', $updatePairs);

        // Insert the output entries into _pc table or update existing entries
        $insertQuery = "INSERT INTO $pcTable (ENTRY_DATE, " . implode(', ', array_keys($columns)) . ") VALUES ('$dateInput', " . implode(', ', $columns) . ")
            ON DUPLICATE KEY UPDATE $updatePairsString";
        mysqli_query($conn, $insertQuery);
    }
}
?>
<div class="container">
    <div class="card">
        <!-- Date Input Form -->
        <form method="POST" action="">
            <label for="dateInput">Date:</label>
            <input type="date" name="dateInput" id="dateInput" required>
            <button type="submit" name="submit">Calculate Power Consumption</button>
        </form>
    </div>
</div>

<?php
include_once '../main/footer.php'
?>