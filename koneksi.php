<?php
$host = "localhost";
$dbname = "boboko";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
