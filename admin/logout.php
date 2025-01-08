<?php
session_start();

// Unset or destroy the session variables
unset($_SESSION['logged_account_id']);
unset($_SESSION['logged_staff_name']);

// Destroy the entire session
session_destroy();

// Redirect the user to the home page
header("Location: ../index.php");
exit();
