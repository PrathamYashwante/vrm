<?php
include_once '../main/header.php';
// Check if session is not started or username is not set
if (!isset($_SESSION['username'])) {
    header("Location: ../login/login.php");
    exit();
}
?>

<?php
require_once '../database/dbh.inc.php';


if (isset($_GET['table'])) {
    $table = $_GET['table'];
} else {
    die("Table name not specified.");
}

$numColumns = 0; // Initialize the number of columns variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the number of columns to add
    if (isset($_POST['num_columns'])) {
        $numColumns = intval($_POST['num_columns']);
    } else {
        die("Number of columns not specified.");
    }

    // Get the column names from user input
    $columnNames = array();
    for ($i = 1; $i <= $numColumns; $i++) {
        if (isset($_POST["column_$i"])) {
            $columnName = $_POST["column_$i"];
            $columnNames[] = $columnName;
        }
    }

    // Alter the original table by adding the new columns
    $query = "ALTER TABLE $table ";
    $alterStatements = array();
    foreach ($columnNames as $columnName) {
        $alterStatements[] = "ADD COLUMN $columnName DOUBLE";
    }
    $query .= implode(", ", $alterStatements);

    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error altering table $table: " . mysqli_error($conn));
    }

    // Alter the corresponding table with _pc suffix by adding the new columns
    $pcTable = $table . '_pc';
    $pcQuery = "ALTER TABLE $pcTable ";
    $pcAlterStatements = array();
    foreach ($columnNames as $columnName) {
        $pcAlterStatements[] = "ADD COLUMN $columnName DOUBLE";
    }
    $pcQuery .= implode(", ", $pcAlterStatements);

    $pcResult = mysqli_query($conn, $pcQuery);
    if (!$pcResult) {
        die("Error altering table $pcTable: " . mysqli_error($conn));
    }

    // Check if the corresponding table with _sm suffix exists
    $smTable = $table . '_sm';
    $checkSmQuery = "SHOW TABLES LIKE '$smTable'";
    $smResult = mysqli_query($conn, $checkSmQuery);
    if (mysqli_num_rows($smResult) > 0) {
        // Alter the corresponding table with _sm suffix by adding the new columns
        $smQuery = "ALTER TABLE $smTable ";
        $smAlterStatements = array();
        foreach ($columnNames as $columnName) {
            $smAlterStatements[] = "ADD COLUMN $columnName DOUBLE";
        }
        $smQuery .= implode(", ", $smAlterStatements);

        $smResult = mysqli_query($conn, $smQuery);
        if (!$smResult) {
            die("Error altering table $smTable: " . mysqli_error($conn));
        }

    } else {
        echo "Table $smTable does not exist.";
    }
    
}
?>

<div class="container">
    <div class="card">

        <h2>Alter Table: <?php echo $table; ?></h2>
        <form method="POST">
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num_columns'])) {
                $numColumns = intval($_POST['num_columns']);
            } ?>

            <label for="num_columns">Number of Columns to Add:</label>
            <input type="number" name="num_columns" id="num_columns" min="1" value="<?php echo $numColumns; ?>"><br><br>

            <?php if ($numColumns > 0) {
                for ($i = 1; $i <= $numColumns; $i++) : ?>
                    <label for="column_<?php echo $i; ?>">Column <?php echo $i; ?> Name:</label>
                    <input type="text" name="column_<?php echo $i; ?>" id="column_<?php echo $i; ?>" required><br><br>
            <?php endfor;
            } ?>

            <button type="submit">Add Columns</button>
        </form>
    </div>
</div>
<?php
include_once '../main/footer.php';
?>