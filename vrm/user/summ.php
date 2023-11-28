<?php
include_once '../main/header copy.php';
?>
<link rel="stylesheet" type="text/css" href="../main/style.css">

<?php

// Step 2: Provide table names and production values input
$tableData = array();
$date = '';
$numTables = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    }

    // Get the number of tables input dynamically
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
require_once '../database/dbh.inc.php';
?>
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
                <select name="tableData[<?php echo $i; ?>][tableName]" id="<?php echo $tableNameId; ?>" required>
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
<?php

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


            // Step 3.e: Store the processed data for the table
            $tableDataOutput[] = array(
                'tableName' => $tableName,
                'filteredColumns' => $filteredColumns,
                'row' => $row, // Include the actual values from the database
                'prodValue' => $prodValue, // Include the production value from user input
                'dividedValues' => $dividedValues
            );
        } else {
            echo "<script>alert('No data found for the power consumption table $tableName on date: $date'); window.location.href = 'summ.php';</script>";
            exit;
        }
    }
}

// Check if the form has been submitted and data is available
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($tableDataOutput)) {
    echo "<div class='container'><div class='card'><h3>Output:</h3>";
    foreach ($tableDataOutput as $index => $table) {
        $tableName = $table['tableName'];
        $filteredColumns = $table['filteredColumns'];
        $row = $table['row'];
        $dividedValues = $table['dividedValues'];
        $prodValue = $table['prodValue'];

        echo "<h4>Table Name: $tableName</h4>";
        echo "<table>";
        echo "<tr>";
        echo "<th>Name of the values</th>";
        echo "<th>Values</th>";
        echo "<th>PROD</th>";
        echo "<th>Kwh/mt</th>";
        echo "</tr>";

        $subtotalColumn = null;
        foreach ($filteredColumns as $column) {
            if ($column == 'SUBTOTAL') {
                $subtotalColumn = $column;
                continue;
            }

            echo "<tr>";
            echo "<td>$column</td>";
            echo "<td>" . $row[$column] . "</td>";
            echo "<td>$prodValue</td>";
            echo "<td>" . $dividedValues[$column] . "</td>";
            echo "</tr>";
        }

        // Add subtotal column if present
        if ($subtotalColumn) {
            echo "<tr>";
            echo "<td>$subtotalColumn</td>";
            echo "<td>" . $row[$subtotalColumn] . "</td>";
            echo "<td>$prodValue</td>";
            echo "<td>" . $dividedValues[$subtotalColumn] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<br><br>";
    }
    echo "</div></div>";
}


include_once '../main/footer.php';
?>