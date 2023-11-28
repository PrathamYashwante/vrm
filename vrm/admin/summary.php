<?php
include_once '../main/header.php';
require_once '../database/dbh.inc.php';
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



// Function to generate PDF using FPDF
function generatePDF($tableDataOutput, $date)
{
    require '../fpdf/fpdf.php';

    // Create new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $filename = str_replace('_', '', $date); // Remove hyphens from the date
    $formattedDate = date('d/m/Y', strtotime($date));
    $pdf->Cell(0, 10, 'Date: ' . strtoupper($formattedDate), 0, 1);
    foreach ($tableDataOutput as $index => $table) {
        $tableName = $table['tableName'];
        $filteredColumns = $table['filteredColumns'];
        $row = $table['row'];
        $dividedValues = $table['dividedValues'];
        $prodValue = $table['prodValue'];

        // Set font and table header
        $pdf->SetFont('Arial', 'B', 12);
        // Remove "_pc" from the end of the table name
        $tableName = rtrim($tableName, '_pc');

        
        // Add table name as a header
        $pdf->Cell(0, 10, 'Table Name: ' . strtoupper($tableName), 0, 1); // Add this line
        $pdf->Ln(8); // Add extra line spacing after the table name

        // Table header
        $pdf->Cell(70, 10, 'Name of the values', 1);
        $pdf->Cell(40, 10, 'Values', 1);
        $pdf->Cell(40, 10, 'PROD', 1);
        $pdf->Cell(40, 10, 'Kwh/mt', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);

        // Table rows
        foreach ($filteredColumns as $column) {
            $pdf->Cell(70, 10, $column, 1);
            $pdf->Cell(40, 10, $row[$column], 1);
            $pdf->Cell(40, 10, $prodValue, 1);
            $pdf->Cell(40, 10, $dividedValues[$column], 1);
            $pdf->Ln();
        }

        // Add a blank row for spacing
        $pdf->Ln();
    }

    $pdf->Output($filename . '_summary.pdf', 'F');

    $updatedFileName = $filename . '_summary.pdf';

    return $updatedFileName;

    // Output the PDF for download with the updated filename
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


            // Step 3.d: Store the processed data for the table
            $tableDataOutput[] = array(
                'tableName' => $tableName,
                'filteredColumns' => $filteredColumns,
                'row' => $row, // Include the actual values from the database
                'prodValue' => $prodValue, // Include the production value from user input
                'dividedValues' => $dividedValues
            );
        }
    }
}


// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($tableDataOutput)) {
    $tempFilename = generatePDF($tableDataOutput, $date);
}
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($tableDataOutput)) {
    // Display the success message with the link to the PDF file
    echo "<div class='container'><div class='card'>Data inserted successfully into the tables and the PDF is generated.
  <a href='" . $tempFilename . "' target='_blank'>Click here to view the PDF</a></div></div>";
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
<?php
include_once '../main/footer.php';
?>