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
    $month = date('m', strtotime($dateInput));
    $year = date('Y', strtotime($dateInput));
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    $output = array();

    foreach ($tables as $table) {
        // Prepare the output array for the current table
        $output[$table] = array();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = $year . '-' . $month . '-' . sprintf("%02d", $day);
            $previousDate = date('Y-m-d', strtotime($currentDate . ' -1 day'));

            // Get previous day power consumption
            $query = "SELECT * FROM $table WHERE ENTRY_DATE = '$previousDate'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $previousDayEntries = mysqli_fetch_assoc($result);
            } else {
                // Use 0 as the default value if no entries found
                $previousDayEntries = array();
                $columnsQuery = "SHOW COLUMNS FROM $table";
                $columnsResult = mysqli_query($conn, $columnsQuery);

                if ($columnsResult) {
                    while ($columnRow = mysqli_fetch_assoc($columnsResult)) {
                        $column = $columnRow['Field'];
                        if ($column !== 'ENTRY_DATE') {
                            $previousDayEntries[$column] = 0;
                        }
                    }
                } else {
                    die("Error retrieving columns for table $table: " . mysqli_error($conn));
                }
            }

            // Get current day power consumption
            $query = "SELECT * FROM $table WHERE ENTRY_DATE = '$currentDate'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $currentDayEntries = mysqli_fetch_assoc($result);
            } else {
                // Use 0 as the default value if no entries found
                $currentDayEntries = array();
                $columnsQuery = "SHOW COLUMNS FROM $table";
                $columnsResult = mysqli_query($conn, $columnsQuery);

                if ($columnsResult) {
                    while ($columnRow = mysqli_fetch_assoc($columnsResult)) {
                        $column = $columnRow['Field'];
                        if ($column !== 'ENTRY_DATE') {
                            $currentDayEntries[$column] = 0;
                        }
                    }
                } else {
                    die("Error retrieving columns for table $table: " . mysqli_error($conn));
                }
            }

            // Prepare the output array with power consumption values for each day
            $differences = array();
            foreach ($currentDayEntries as $column => $currentValue) {
                if ($column !== 'ENTRY_DATE') {
                    $previousValue = $previousDayEntries[$column];
                    $differences[$column] = [$previousValue, $currentValue];
                }
            }

            $output[$table][$currentDate] = $differences;
        }
    }

    // Generate Excel file content
    $filename = 'meter_readings.xls';
    $xlsContent = '';

    // Create the top header
    $topHeader = "<tr><th colspan='" . (count($output) + 1) . "'></th></tr>";

    foreach ($output as $table => $dates) {
        $header = "<tr><th colspan='" . (count($dates) + 1) . "'></th></tr>";
        $dateHeader = "<tr><th style='border: 1px solid #000;'>$table</th>";

        // Iterate over dates
        foreach ($dates as $date => $columns) {
            $formattedDate = date('j M', strtotime($date));
            $dateHeader .= "<th style='border: 1px solid #000; text-align: center;'></th>";
        }
        $dateHeader .= "</tr>";

        $tableData = '';

        // Iterate over columns
        foreach ($columns as $column => $values) {
            $tableData .= "<tr>";
            $tableData .= "<td style='border: 1px solid #000; text-align: center;'>$column</td>";

            // Iterate over dates
            foreach ($dates as $date => $columns) {
                if (isset($columns[$column])) {
                    $previousValue = $columns[$column][0];
                    $currentValue = $columns[$column][1];
                } else {
                    $previousValue = 0;
                    $currentValue = 0;
                }

                $tableData .= "<td style='border: 1px solid #000; text-align: center;'>$currentValue</td>";
            }

            $tableData .= "</tr>";
        }

        $xlsContent .= "<table style='border-collapse: collapse;'>";
        $xlsContent .= "<thead>$header $dateHeader</thead>";
        $xlsContent .= "<tbody>$tableData</tbody>";
        $xlsContent .= "</table>";
    }

    // Set headers for the Excel file
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");

    $dateHeaderTOP = "<tr><th style='border: 1px solid #000;'>TABLE</th>";

    // Iterate over dates
    foreach ($dates as $date => $columns) {
        $formattedDate = date('j M', strtotime($date));
        $dateHeaderTOP .= "<th style='border: 1px solid #000; text-align: center;'>$formattedDate</th>";
    }
    $dateHeaderTOP .= "</tr>";

    // Excel file content
    echo "<table style='border-collapse: collapse;'><thead>$topHeader $dateHeaderTOP</thead></table>";
    echo $xlsContent;
    exit();
}
?>
<?php include_once '../main/header.php';

?>
<div class="container">
    <div class="card">
        <!-- Date Input Form -->
        <form method="POST" action="">
            <label for="dateInput">Date:</label>
            <input type="month" name="dateInput" id="dateInput" required>
            <button type="submit" name="submit">Retrieve Meter Readings</button>
        </form>
    </div>
</div>