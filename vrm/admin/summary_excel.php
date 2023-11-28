<?php
// Step 2: Provide table names and production values input
$tableData = array();
$date = '';
$numTables = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    }

    // Get the number of tables input 
    $numTables = isset($_POST['numTables']) ? intval($_POST['numTables']) : 0;

    // Retrieve the table data for each input dynamically
    if (isset($_POST['tableData'])) {
        for ($i = 0; $i < $numTables; $i++) {
            $tableName = $_POST['tableData'][$i]['tableName'];
            $prodValue = doubleval($_POST['tableData'][$i]['prodValue']);

            // Add the table data to the $tableData array
            $tableData[] = array(
                'tableName' => $tableName,
                'prodValue' => $prodValue
            );
        }
    }
}

?>
<?php
// Function to generate Excel sheet
function generateExcel($tableDataOutput, $date)
{
    ob_start();
    echo '<table>';

    $numTables = count($tableDataOutput);
    $numRows = 2;
    $numCols = ceil($numTables / $numRows);

    // Generate the table in a 2x3 matrix format with spacing
    for ($row = 0; $row < $numRows; $row++) {
        echo '<tr>';
        for ($col = 0; $col < $numCols; $col++) {
            $index = $row * $numCols + $col;
            if ($index < $numTables) {
                echo '<td>';
                $tableN = rtrim($tableDataOutput[$index]['tableName'], '_pc');
                echo '<h3>' . $tableN . '</h3>';
                echo '<table border="1">';
                echo '<tr><th>Name of the values</th><th>Values</th><th>Production Value</th><th>Kwh/mt (divided value)</th></tr>';

                $filteredColumns = $tableDataOutput[$index]['filteredColumns'];
                $rowValues = $tableDataOutput[$index]['row'];
                $dividedValues = $tableDataOutput[$index]['dividedValues'];
                $prodValue = $tableDataOutput[$index]['prodValue'];

                foreach ($filteredColumns as $column) {
                    echo '<tr>';
                    echo '<td>' . $column . '</td>';
                    echo '<td>' . $rowValues[$column] . '</td>';
                    echo '<td>' . $prodValue . '</td>';
                    echo '<td>' . $dividedValues[$column] . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
                echo '</td>';

                // Add an empty cell for spacing between tables
                echo '<td></td>';
            } else {
                // Add empty cells for the remaining columns if the number of tables is less than 6
                echo '<td></td>';
            }
        }
        echo '</tr>';

        // Add an empty row for spacing between tables
        echo '<tr></tr>';
    }

    echo '</table>';

    $content = ob_get_clean();

    // Set headers
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $date . '_summary.xls"');


    echo $content;


    exit();
}


// Step 3: Process each table and store the data
$tableDataOutput = array(); // Array to store processed data for each table

if (!empty($tableData)) {
    foreach ($tableData as $data) {
        $tableName = $data['tableName'];
        $prodValue = doubleval($data['prodValue']);

        require_once '../database/dbh.inc.php';

        // Step 3.a: Extract the data for the table on the specified date
        $query = "SELECT * FROM $tableName WHERE ENTRY_DATE = '$date'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Get the column names for the table
            $columns = array_keys($row);

            // Remove the 'ENTRY_DATE' and 'subtotal' columns
            $filteredColumns = array_filter($columns, function ($column) {
                return $column !== 'ENTRY_DATE' && $column !== 'subtotal';
            });

            // Step 3.b: Calculate the divided values
            $dividedValues = [];
            foreach ($filteredColumns as $column) {
                $dividedValues[$column] = round($row[$column] / $prodValue, 2);
            }

            // Step 3.d: Store the dividedValues into the database
            $modifiedTableName = str_ireplace('_pc', '_sm', $tableName);

            // Check if the data already exists for the specified date in the table
            $query = "SELECT * FROM $modifiedTableName WHERE ENTRY_DATE = '$date'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                // Update the existing row
                $updateQuery = "UPDATE $modifiedTableName SET ";
                foreach ($dividedValues as $column => $value) {
                    $updateQuery .= "$column = $value, ";
                }
                $updateQuery = rtrim($updateQuery, ', ');
                $updateQuery .= " WHERE ENTRY_DATE = '$date'";
                mysqli_query($conn, $updateQuery);
            } else {
                // Insert a new row
                $insertQuery = "INSERT INTO $modifiedTableName (ENTRY_DATE";
                $insertValues = "('$date'";
                foreach ($dividedValues as $column => $value) {
                    $insertQuery .= ", $column";
                    $insertValues .= ", $value";
                }
                $insertQuery .= ") VALUES $insertValues)";
                mysqli_query($conn, $insertQuery);
            }

            // Check if 'SUBTOTAL' column is present and add it last
            if (in_array('SUBTOTAL', $filteredColumns)) {
                $subtotalKey = array_search('SUBTOTAL', $filteredColumns);
                unset($filteredColumns[$subtotalKey]);
                $filteredColumns[] = 'SUBTOTAL';
            }

            // Step 3.c: Calculate the total divided value
            $totalDividedValue = array_sum($dividedValues);

            // Step 3.d: Store the processed data for the table
            $tableDataOutput[] = array(
                'tableName' => $tableName,
                'filteredColumns' => $filteredColumns,
                'row' => $row, // Include the actual values from the database
                'prodValue' => $prodValue, // Include the production value from user input
                'dividedValues' => $dividedValues,
                'totalDividedValue' => $totalDividedValue
            );
        }
    }
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($tableDataOutput)) {
    generateExcel($tableDataOutput, $date);
    
}

?>
<?php
include_once '../main/header.php';
require_once '../database/dbh.inc.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($tableDataOutput)) {
    echo "<div class='container'><h3 class='card'>Data inserted successfully into the tables and the Excel file generated and saved on the server..</h3></div>";
}
?>
<link rel="stylesheet" type="text/css" href="../main/style.css">

<div class="container">
    <div class="card">
        <!-- Step 2: Table names and production values input -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" required value="<?php echo $date; ?>"><br><br>
            </div>
            <h4>Please select all the summary tables</h4>
            <div class="form-group">
                <label for="numTables">Number of Tables:</label>
                <input type="number" name="numTables" id="numTables" min="0" required value="<?php echo $numTables; ?>"><br><br>
            </div>
            <?php
            $pcTables = array();
        $query = "SELECT name_of_table FROM table_timestamps WHERE name_of_table LIKE '%\_pc' AND REPLACE(name_of_table, '_pc', '_sm') IN (SELECT name_of_table FROM table_timestamps WHERE name_of_table LIKE '%\_sm')";
  $result = mysqli_query($conn, $query);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $pcTables[] = $row['name_of_table'];
                }
            } else {
                die("Error retrieving PC tables: " . mysqli_error($conn));
            }

            for ($i = 0; $i < $numTables; $i++) {
                $index = $i + 1;
                $tableNameId = 'tableName_' . $index;
                $prodValueId = 'prodValue_' . $index;
            ?>

                <label for="<?php echo $tableNameId; ?>">Table Name <?php echo $index; ?>:</label>
                <select name="tableData[<?php echo $i; ?>][tableName]" id="<?php echo $tableNameId; ?>" required class="dropdown">
                    <?php
                    foreach ($pcTables as $table) {
                        echo '<option value="' . $table . '">' . $table . '</option>';
                    }
                    ?>
                </select><br><br>
                <label for="<?php echo $prodValueId; ?>">Production Value <?php echo $index; ?>:</label>
                <input type="number" name="tableData[<?php echo $i; ?>][prodValue]" id="<?php echo $prodValueId; ?>" step="0.01" required><br><br>
            <?php
            }
            ?>


            <button type="submit">Submit</button>
        </form>
    </div>
</div>