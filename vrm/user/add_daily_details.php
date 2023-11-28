<?php
include_once '../main/header copy.php';

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

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


if (isset($_POST['submit'])) {
    $dailyDate = $_POST['ENTRY_DATE'];

    // Check if the date is a duplicate for any table
    $duplicateTables = array();
    foreach ($tables as $table) {
        $duplicateQuery = "SELECT ENTRY_DATE FROM $table WHERE ENTRY_DATE = '$dailyDate'";
        $duplicateResult = mysqli_query($conn, $duplicateQuery);

        if (mysqli_num_rows($duplicateResult) > 0) {
            $duplicateTables[] = $table;
        }
    }

    if (!empty($duplicateTables)) {
        // Update the existing data for duplicate entries
        foreach ($duplicateTables as $table) {
            $tableData = array();
            $columnNames = $tableColumns[$table];

            foreach ($columnNames as $columnName) {
                if ($columnName === 'ENTRY_DATE') {
                    continue;
                }

                $value = $_POST[$table][$columnName];

                if (!is_numeric($value)) {
                    echo "<div class='container'><h3 class='card'>Error: Invalid input for column '$columnName' in table '$table'. Please enter a numeric value.</h3></div>";
                    exit();
                }

                $tableData[$columnName] = $value;
            }

            $updateValues = array();
            foreach ($tableData as $columnName => $value) {
                $updateValues[] = "$columnName = '" . mysqli_real_escape_string($conn, $value) . "'";
            }
            $updateValues = implode(", ", $updateValues);

            $updateQuery = "UPDATE $table SET $updateValues WHERE ENTRY_DATE = '$dailyDate'";
            $result = mysqli_query($conn, $updateQuery);

            if (!$result) {
                die("Error updating data in table $table: " . mysqli_error($conn));
            }
        }

        echo "<div class='container'><h3 class='card'>Data updated successfully for the duplicate entries.</h3></div>";
    }

    // Insert the input data into the non-duplicate tables
    $nonDuplicateTables = array_diff($tables, $duplicateTables);
    foreach ($nonDuplicateTables as $table) {
        $tableData = array();
        $columnNames = $tableColumns[$table];

        foreach ($columnNames as $columnName) {
            if ($columnName === 'ENTRY_DATE') {
                continue;
            }

            $value = $_POST[$table][$columnName];

            if (!is_numeric($value)) {
                echo "<div class='container'><h3 class='card'>Error: Invalid input for column '$columnName' in table '$table'. Please enter a numeric value.</h3></div>";
                exit();
            }

            $tableData[$columnName] = $value;
        }

        $columnNames = implode(", ", array_keys($tableData));
        $values = implode(", ", array_map(function ($value) use ($conn) {
            return "'" . mysqli_real_escape_string($conn, $value) . "'";
        }, $tableData));

        $insertQuery = "INSERT INTO $table (ENTRY_DATE, $columnNames) VALUES ('$dailyDate', $values)";
        $result = mysqli_query($conn, $insertQuery);

        if (!$result) {
            die("Error inserting data into table $table: " . mysqli_error($conn));
        }
    }

    echo "<div class='container'><h3 class='card'>Data inserted successfully into the tables.</h3></div>";
}
?>

<style>
    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .form-group-d {
        align-items: center;
        margin-bottom: 10px;
    }

    .label {
        flex: 0 0 30%;
        font-weight: bold;
        text-align: right;
        margin-right: 10px;
        font-size: 16px;
    }

    .input {
        flex: 1;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        font-size: 20px;
    }
</style>

<div class="container">
    <div class="card">
        <h1>Daily Meter Readings</h1>
        <p>Please select from below the date for adding the meter readings.</p>

        <form method="POST" action="">

            <div class="form-group-d">
                <label for="ENTRY_DATE">Daily Date:</label>
                <input type="date" name="ENTRY_DATE" id="ENTRY_DATE" required>
            </div>
    </div>

    <?php foreach ($tables as $table) { ?>
        <?php if (substr($table, -3) !== '_pc' && substr($table, -3) !== '_sm' && $table !== 'users') { ?>
            <div class="card">
                <h2 class="table-heading">Table: <?php echo strtoupper($table); ?></h2>
                <?php $columnNames = $tableColumns[$table];
                array_shift($columnNames); ?>
                <?php foreach ($columnNames as $columnName) { ?>
                    <div class="form-group">
                        <label for="<?php echo $table . '_' . $columnName; ?>" class="label"><?php echo  $columnName; ?>:</label>
                        <input type="text" name="<?php echo $table . '[' . $columnName . ']'; ?>" id="<?php echo $table . '_' . $columnName; ?>" class="input">
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>

    <button type="submit" name="submit" class="button">Insert Data</button>

    </form>
</div>