<?php
include_once '../main/header.php';

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}

?>

<style>
    .card {
        background-color: #f8f9fa;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 30px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        max-width: 600px;
        margin: 0 auto;
    }

    .form-group {
        width: 100%;
        margin-bottom: 10px;
    }

    .form-group label {
        display: block;
        text-align: left;
        margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="checkbox"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>


<div class="container">
    <div class="card">
        <form method="POST" action="">
            <h2>Create Table</h2>
            <div class="form-group">
                <label for="tableName">Table Name:</label>
                <input type="text" name="tableName" id="tableName" required>
            </div>
            <div class="form-group">
                <label for="numColumns">Number of Columns:</label>
                <input type="number" name="numColumns" id="numColumns" min="1" max="20" required>
            </div>
            <div class="form-group">
                <label for="createSummaryTable">If you want to include this table in the summary sheet then please check the below box:</label>
                <input type="checkbox" name="createSummaryTable" id="createSummaryTable">
            </div>
            <button type="submit" name="submit">Create Columns Inputs</button>
        </form>
    </div>
</div>


<?php
if (isset($_POST['submit'])) {
    $tableName = $_POST['tableName'];
    $numColumns = $_POST['numColumns'];
    $createSummaryTable = isset($_POST['createSummaryTable']);

    require_once '../database/dbh.inc.php';

    // Check if the table already exists
    $checkTableQuery = "SHOW TABLES LIKE '$tableName'";
    $checkTableResult = mysqli_query($conn, $checkTableQuery);

    if (mysqli_num_rows($checkTableResult) > 0) {
        echo "<div class='container'><h3 class='card'>Error: Table '$tableName' already exists.</h3></div>";
        include_once '../main/footer.php';
        exit;
    }

    // Check for numeric table name
    if (is_numeric($tableName)) {
        echo "<div class='container'><h3 class='card'>Error: Numeric table names are not allowed.</h3></div>";
        include_once '../main/footer.php';
        exit;
    }

    // Check for special characters in table name
    $pattern = '/[\'^£$%&*()}{@#~?><>,|=+¬-]/';
    if (preg_match($pattern, $tableName)) {
        echo "<div class='container'><h3 class='card'>Error: Special characters are not allowed in the table name.</h3></div>";
        include_once '../main/footer.php';
        exit;
    }
    echo '<div class="container">
    <div class="card">
        <h2>Table Name: ' . $tableName . '</h2>
        <h2>Number of columns in the table:  ' . $numColumns . '</h2>

        <form method="POST" action="">
            <input type="hidden" name="tableName" value="' . htmlspecialchars($tableName) . '">
            <input type="hidden" name="numColumns" value="' . htmlspecialchars($numColumns) . '">
            <input type="hidden" name="createSummaryTable" value="' . ($createSummaryTable ? '1' : '0') . '">

            ';

    for ($i = 0; $i < $numColumns; $i++) {
        echo '<div class="form-group">
                    <label for="column' . $i . '">Column ' . ($i + 1) . ' Name:</label>
                    <input type="text" name="columnNames[]" id="column' . $i . '" required>
                </div>';
    }

    echo '<button type="submit" name="createTable">Create Table</button>
        </form>
    </div>
</div>';
}

if (isset($_POST['createTable'])) {
    $tableName = $_POST['tableName'];
    $columnNames = $_POST['columnNames'];
    $numColumns = $_POST['numColumns'];
    $createSummaryTable = $_POST['createSummaryTable'];

    // Check for duplicate column names
    $uniqueColumnNames = array_unique($columnNames);
    if (count($columnNames) !== count($uniqueColumnNames)) {
        echo "<div class='container'><h3 class='card'>Error: Duplicate column names are not allowed.</h3></div>";
        include_once '../main/footer.php';
        exit;
    }

    // Check for numeric column names
    foreach ($columnNames as $columnName) {
        if (is_numeric($columnName)) {
            echo "<div class='container'><h3 class='card'>Error: Numeric column names are not allowed.</h3></div>";
            include_once '../main/footer.php';
            exit;
        }
    }

    // Check for special characters in column names
    $pattern = '/[\'^£$%&*()}{@#~?><>,|=+¬-]/';
    foreach ($columnNames as $columnName) {
        if (preg_match($pattern, $columnName)) {
            echo "<div class='container'><h3 class='card'>Error: Special characters are not allowed in column names.</h3></div>";
            include_once '../main/footer.php';
            exit;
        }
    }

    require_once '../database/dbh.inc.php';

    // Create the SQL statement
    $sql = "CREATE TABLE $tableName (ENTRY_DATE DATE PRIMARY KEY, ";
    foreach ($columnNames as $columnName) {
        $sql .= "$columnName DOUBLE, ";
    }
    $sql = rtrim($sql, ", "); 
    $sql .= ")";

    // Create the SQL statement for the power consumption table
    $powerConsumptionTableName = $tableName . "_pc";
    $powerConsumptionSql = "CREATE TABLE $powerConsumptionTableName (ENTRY_DATE DATE PRIMARY KEY, ";
    foreach ($columnNames as $columnName) {
        $powerConsumptionSql .= "$columnName DOUBLE, ";
    }
    $powerConsumptionSql .= "SUBTOTAL DOUBLE)";

    // Create the SQL statement for the summary table
    $summaryTableName = $tableName . "_sm";
    $summarySql = "CREATE TABLE $summaryTableName (ENTRY_DATE DATE PRIMARY KEY, ";
    foreach ($columnNames as $columnName) {
        $summarySql .= "$columnName DOUBLE, ";
    }
    $summarySql .= "SUBTOTAL DOUBLE)";

    $result = mysqli_query($conn, $sql);

    // Check if table creation was successful
    if ($result) {
        // Create the power consumption table
        mysqli_query($conn, $powerConsumptionSql);
        echo "<div class='container'><h3 class='card'>Table '$tableName' created successfully with $numColumns columns.</h3></div>";
        echo "<div class='container'><h3 class='card'>Power Consumption table '$powerConsumptionTableName' created successfully with $numColumns columns.</h3></div>";

        // Create the summary table if the checkbox is checked
        if ($createSummaryTable) {
            mysqli_query($conn, $summarySql);
            echo "<div class='container'><h3 class='card'>Summary table '$summaryTableName' created successfully with $numColumns columns.</h3></div>";

            // Insert the summary table name and timestamp into the table_timestamps table
            $summaryTimestampSql = "INSERT INTO table_timestamps (name_of_table, timestamp_of_table) VALUES ('$summaryTableName', NOW())";
            mysqli_query($conn, $summaryTimestampSql);
        }

        // Insert the main table name and timestamp into the table_timestamps table
        $tableTimestampSql = "INSERT INTO table_timestamps (name_of_table, timestamp_of_table) VALUES ('$tableName', NOW())";
        mysqli_query($conn, $tableTimestampSql);

        // Insert the power consumption table name and timestamp into the table_timestamps table
        if ($powerConsumptionTableName != '') {
            $powerConsumptionTimestampSql = "INSERT INTO table_timestamps (name_of_table, timestamp_of_table) VALUES ('$powerConsumptionTableName', NOW())";
            mysqli_query($conn, $powerConsumptionTimestampSql);
        }
    } else {
        echo "<div class='container'><h3 class='card'>Error creating table: " . mysqli_error($conn) . "</h3></div>";
    }
}

include_once '../main/footer.php';
?>