<?php
require_once('koneksi.php');

// Ambil query dari GET
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Membuat prepared statement untuk meningkatkan keamanan
if (!empty(trim($query))) {
    $stmt = $conn->prepare("SELECT id_menu, Nama FROM products WHERE Nama LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("s", $query);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {  // Jika ada hasil
        while ($row = $result->fetch_assoc()) {
            echo '<a href="home.php#' . $row['id_menu'] . '" class="search-result-link">' . $row['Nama'] . '</a><br>';
        }
    } else {  // Jika tidak ada hasil
        echo "product not found";
    }

    $stmt->close();
} else {
    echo "product not found";
}

$conn->close();
