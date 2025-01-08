<?php
session_start();
require_once "../koneksi.php";

// Initialize variables for form validation and item data
$id_menu = $Nama = $kategori = $Harga = "";
$id_menu_err = "";

// Check if item_id is provided in the URL
if (isset($_GET['id_menu']) && !empty($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];

    // Retrieve item details based on item_id
    $sql = "SELECT * FROM products WHERE id_menu = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_id_menu);
        $param_id_menu = $id_menu;

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $Nama = $row['Nama'];
                $kategori = $row['kategori'];
                $Harga = $row['Harga'];
            } else {
                echo "Menu tidak ditemukan.";
                exit();
            }
        } else {
            echo "Gagal mengambil data.";
            exit();
        }
    }
}

// Process form submission when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $Nama = trim($_POST["Nama"]);
    $kategori = trim($_POST["kategori"]);
    $Harga = floatval($_POST["Harga"]); // Convert to float

    // Update the item in the database
    $update_sql = "UPDATE products SET Nama='$Nama', kategori='$kategori', Harga='$Harga' WHERE id_menu='$id_menu'";
    $resultItems = mysqli_query($conn, $update_sql);

    if ($resultItems) {
        // Item updated successfully

        header("Location: ../admin/menu-panel.php");
        echo 'success';
        exit();
    } else {
        echo "Gagal mengedit menu: ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Menu</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url(../img/bg-menu.png);
            background-size: cover;
            color: #1b1b1b;
        }

        .edit-container {
            padding: 50px;
            /* Adjust the padding as needed */
            border-radius: 10px;
            /* Add rounded corners */
            margin: 100px auto;
            /* Center the container horizontally */
            max-width: 500px;
            /* Set a maximum width for the container */
        }
    </style>
</head>

<body>
    <div class="edit-container">
        <div class="edit_wrapper" style="width:500px; height:auto; background-color: #edeae3; border-radius:20px; padding:20px; box-shadow: 2px 2px 10px 4px rgb(14 55 54 / 15%);">
            <div class="wrapper">
                <h2 style="text-align: center;">Edit Menu</h2>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="Nama" class="form-label">Nama menu:</label>
                        <input type="text" name="Nama" id="Nama" class="form-control" placeholder="Masukkan nama menu" value="<?php echo htmlspecialchars($Nama); ?>" required>
                    </div>
                    <div class="form-group" class="form-label">
                        <label for="kategori">Kategori menu:</label>
                        <input type="text" name="kategori" id="kategori" class="form-control" placeholder="Makanan/Minuman" value="<?php echo htmlspecialchars($kategori); ?>" required>
                    </div>
                    <div class="form-group" class="form-label">
                        <label for="Harga">Harga menu:</label>
                        <input type="number" name="Harga" id="Harga" placeholder="Masukkan harga" class="form-control" value="<?php echo htmlspecialchars($Harga); ?>" required>
                    </div>
                    <br>
                    <input type="hidden" name="id" value="" class="form-control">
                    <button class="btn btn-light" type="submit" name="submit" value="submit" style="border:2px solid #607274; color:#607274">Ubah</button>
                    <a class="btn btn-danger" href="../admin/menu-panel.php">Batalkan</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>