<?php
require_once '../database/dbh.inc.php';

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    
    $table = strtolower($table);

    // Delete the table
    $deleteQuery = "DROP TABLE $table";
    $result = mysqli_query($conn, $deleteQuery);
    



    // Delete the corresponding _pc table if it exists
    $pcTable = $table . '_pc';
    $pcTable = strtolower($pcTable);
    $deletePCTableQuery = "DROP TABLE IF EXISTS $pcTable";
    $resultpc = mysqli_query($conn, $deletePCTableQuery);
    
    


    // Delete the corresponding _sm table if it exists
    $summTable = $table . '_sm';
    $summTable = strtolower($summTable);
    $deletesummTableQuery = "DROP TABLE IF EXISTS $summTable";
    $resultsm = mysqli_query($conn, $deletesummTableQuery);
    
    

    if ($result) {
        $deleteTimestampQuery = "DELETE FROM table_timestamps WHERE name_of_table = '$table'";
        mysqli_query($conn, $deleteTimestampQuery);
    }
    

    if ($resultpc) {
        $deleteTimestampQuerypc = "DELETE FROM table_timestamps WHERE name_of_table = '$pcTable'";
        mysqli_query($conn, $deleteTimestampQuerypc);
    }


    if ($resultsm) {
        $deleteTimestampQuerysumm = "DELETE FROM table_timestamps WHERE name_of_table = '$summTable'";
        mysqli_query($conn, $deleteTimestampQuerysumm);
    }

    // Redirect back to the page displaying the tables
    header("Location: viewtables.php");
    exit();
}
