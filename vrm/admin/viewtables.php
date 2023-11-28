<?php include_once '../main/header.php';

// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}
?>
<style>
    .card {
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 4px;

    }

    .card h3 {
        margin-bottom: 10px;
    }

    .card table {
        width: 100%;
        border-collapse: collapse;
    }

    .card table thead {
        background-color: #f8f9fa;
    }

    .card table th,
    .card table td {
        padding: 10px;
        border: 1px solid #ccc;
    }

    .tables-container {
        display: flex;
        flex-wrap: wrap;
        margin: 10px;
    }

    .tables-container .card {
        flex: 0 0 calc(33.33% - 20px); /* Adjust the width as needed */
        margin: 10px;
    }

    .card-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-top: 10px;
    }

    .card-actions button {
        margin-left: 10px;
    }

    .card-actions a:first-child button {
        margin-left: 0;
    }

    .button-container {
        display: flex;

    }

    .delete-button {
        padding: 10px 50px;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        margin: 10px;
        height: 50px;
    }

    .alter-button {
        padding: 10px 50px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        margin: 10px;
         height: 50px;
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

echo "<div class='tables-container'>";

// Display tables without _pc in their name
echo "<div class='card'>";
echo "<h2>Meter Readings Tables:</h2>";
foreach ($tableColumns as $table => $columnNames) {

    if (substr($table, -3) !== '_pc' && substr($table, -3) !== '_sm') {
        $table = strtoupper($table);
        echo "<h3>Table: $table</h3>";
        echo "<table>";
        echo "<tbody>";
        foreach ($columnNames as $columnName) {
            echo "<tr>";
            echo "<td>$columnName</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<a href=\"../admin/delete_table.php?table=$table\">
            <button class='btn delete-button'>Delete</button>
        </a> 
        <a href=\"../admin/alter_table.php?table=$table\">
            <button class='btn alter-button'>Alter</button>
        </a>";
        echo "<br></br>";
    }
}
echo "</div>";

// Display tables with _pc in their name
echo "<div class='card'>";
echo "<h2>Power Consumption Tables:</h2>";
foreach ($tableColumns as $table => $columnNames) {
    if (substr($table, -3) === '_pc') {
        $table = strtoupper($table);
        echo "<h3>Table: $table</h3>";
        echo "<table>";
        echo "<thead><tr><th>Columns</th></tr></thead>";
        echo "<tbody>";
        foreach ($columnNames as $columnName) {
            echo "<tr>";
            echo "<td>$columnName</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<br></br>";
    }
}
echo "</div>";

// Display tables with _sm in their name
echo "<div class='card'>";
echo "<h2>Summary Tables:</h2>";
foreach ($tableColumns as $table => $columnNames) {
    if (substr($table, -3) === '_sm') {
        $table = strtoupper($table);
        echo "<h3>Table: $table</h3>";
        echo "<table>";
        echo "<thead><tr><th>Columns</th></tr></thead>";
        echo "<tbody>";
        foreach ($columnNames as $columnName) {
            echo "<tr>";
            echo "<td>$columnName</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "<br></br>";
    }
}
echo "</div>";

echo "</div>";


mysqli_close($conn);
?>

<?php
include_once '../main/footer.php';
?>