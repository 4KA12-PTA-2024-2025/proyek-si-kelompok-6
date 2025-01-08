<?php
// Include config file
require_once "../koneksi.php";

// Check if the item_id parameter is set in the URL
if (isset($_GET['id_menu'])) {
    // Get the item_id from the URL and sanitize it
    $ide_menu = intval($_GET['id_menu']);

    // Disable foreign key checks
    $disableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=0;";
    mysqli_query($conn, $disableForeignKeySQL);

    // Construct the DELETE query
    $deleteSQL = "DELETE FROM products WHERE ide_menu = '" . $_GET['ide_menu'] . "';";

    // Execute the DELETE query
    if (mysqli_query($conn, $deleteSQL)) {
        // Item successfully deleted, redirect back to the main page
        header("location: ../admin/menu-panel.php");
        echo 'deleted';
        exit();
    } else {
        // Error occurred during execution, display an error message
        echo "Error: " . mysqli_error($conn);
    }

    // Enable foreign key checks
    $enableForeignKeySQL = "SET FOREIGN_KEY_CHECKS=1;";
    mysqli_query($conn, $enableForeignKeySQL);

    // Close the connection
    mysqli_close($conn);
}
