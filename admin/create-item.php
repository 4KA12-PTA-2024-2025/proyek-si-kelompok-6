<?php
session_start();
require_once "../koneksi.php";

// Inisialisasi variabel dan pesan kesalahan
$Nama = $kategori = $Harga = "";
$Nama_err = $kategori_err = $Harga_err = "";

// Memproses data formulir saat formulir dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Memvalidasi Nama menu
    if (empty(trim($_POST["Nama"]))) {
        $Nama_err = "Nama menu harus diisi.";
    } else {
        $Nama = trim($_POST["Nama"]);
    }

    // Memvalidasi Kategori menu
    if (empty(trim($_POST["kategori"]))) {
        $kategori_err = "Kategori menu harus dipilih.";
    } else {
        $kategori = trim($_POST["kategori"]);
    }

    // Memvalidasi Harga menu
    if (empty(trim($_POST["Harga"]))) {
        $Harga_err = "Harga menu harus diisi.";
    } else {
        $Harga = trim($_POST["Harga"]);
    }

    // Proses upload foto jika tidak ada kesalahan validasi lainnya
    if (empty($Nama_err) && empty($kategori_err) && empty($Harga_err)) {
        // Memeriksa apakah file yang diunggah ada
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = $_FILES['foto'];
            $foto_name = $foto['name'];
            $foto_tmp_name = $foto['tmp_name'];
            $foto_size = $foto['size'];
            $foto_error = $foto['error'];
            $foto_type = $foto['type'];

            // Mendapatkan ekstensi file
            $foto_ext = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));

            // Ekstensi file yang diperbolehkan
            $allowed_ext = array('jpg', 'jpeg', 'png');

            // Memvalidasi ekstensi file
            if (in_array($foto_ext, $allowed_ext)) {
                // Direktori tempat menyimpan file yang diunggah
                $upload_dir = '../img/';

                // Membuat nama file baru untuk mencegah duplikat
                $foto_new_name = uniqid('', true) . '.' . $foto_ext;

                // Menyimpan file ke direktori
                move_uploaded_file($foto_tmp_name, $upload_dir . $foto_new_name);

                // Menyimpan informasi menu ke dalam database
                $sql = "INSERT INTO products (Nama, kategori, Harga, gambar) VALUES (?, ?, ?, ?)";

                if ($stmt = mysqli_prepare($conn, $sql)) {
                    // Bind parameter ke statement
                    mysqli_stmt_bind_param($stmt, "ssis", $param_Nama, $param_Kategori, $param_Harga, $param_Foto);

                    // Set parameter
                    $param_Nama = $Nama;
                    $param_Kategori = $kategori;
                    $param_Harga = $Harga;
                    $param_Foto = $foto_new_name;

                    // Mengeksekusi statement
                    if (mysqli_stmt_execute($stmt)) {
                        // Redirect ke halaman sukses
                        header('Location: menu-panel.php');
                        exit();
                    } else {
                        echo "Oops! Terjadi kesalahan. Silakan coba lagi nanti.";
                    }

                    // Menutup statement
                    mysqli_stmt_close($stmt);
                }
            } else {
                echo "File yang diunggah harus berupa JPG, JPEG, atau PNG.";
            }
        } else {
            echo "Silakan pilih file untuk diunggah.";
        }
    }

    // Menutup koneksi
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Item</title>

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
                <h2 style="text-align: center;">Tambah Item</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="Nama">Nama menu:</label>
                        <input type="text" name="Nama" id="Nama" placeholder="Masukkan nama menu" required class="form-control <?php echo (!empty($Nama_err)) ? 'error' : ''; ?>" value="<?php echo $Nama; ?>">
                        <span class="invalid-feedback"><?php echo $Nama_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="kategori">Kategori menu:</label>
                        <select name="kategori" id="kategori" class="form-control <?php echo (!empty($kategori_err)) ? 'error' : ''; ?>" required>
                            <option value="">Pilih kategori</option>
                            <option value="Makanan" <?php echo ($kategori == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                            <option value="Minuman" <?php echo ($kategori == 'Minuman') ? 'selected' : ''; ?>>Minuman</option>
                        </select>
                        <span class="invalid-feedback"><?php echo $kategori_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="Harga">Harga menu :</label>
                        <input type="number" name="Harga" id="Harga" placeholder="12000" required class="form-control <?php echo (!empty($Harga_err)) ? 'error' : ''; ?>" value="<?php echo $Harga; ?>">
                        <span class="invalid-feedback"><?php echo $Harga_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto menu:</label>
                        <input type="file" name="foto" id="foto" class="form-control-file">
                    </div>

                    <div class="form-group"></div>
                    <button class="btn btn-light" type="submit" name="submit" value="Tambah" style="border:2px solid #607274; color:#607274">Tambah</button>
                    <a class="btn btn-danger" href="../admin/menu-panel.php">Batalkan</a>
            </div>
            </form>
        </div>
    </div>
</body>

</html>