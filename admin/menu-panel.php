<?php
session_start(); // Ensure session is started
?>
<?php  include'../admin/dashHeader.php'; ?>
<style>
    .wrapper {
        width: 1300px;
        padding-left: 200px;
        padding-top: 20px
    }
</style>

<div class="wrapper">
    <div class="container-fluid pt-5 pl-600">
        <div class="row">
            <div class="m-50">
                <div class="mt-5 mb-3">
                    <h2 class="pull-left">Detail Menu</h2>
                    <a href="../admin/create-item.php" class="btn btn-outline-dark"><i class="fa fa-plus"></i> Tambah Item</a>
                </div>
                <div class="mb-3">
                    <form method="POST" action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <select name="search" id="search" class="form-control">
                                    <option value="">Pilih kategori</option>
                                    <option value="Minuman">Minuman</option>
                                    <option value="Makanan">Makanan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Cari</button>
                            </div>
                            <div class="col" style="text-align: right;">
                                <a href="menu-panel.php" class="btn btn-light">Tampilkan Semua</a>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
                // Include config file
                require_once "../koneksi.php";

                if (isset($_POST['search']) && !empty($_POST['search'])) {
                    $search = $_POST['search'];
                    $sql = "SELECT * FROM products WHERE kategori LIKE '%$search%' OR Nama LIKE '%$search%' OR id_menu LIKE '%$search%' ORDER BY id;";
                } else {
                    // Default query to fetch all items
                    $sql = "SELECT * FROM products ORDER BY id_menu;";
                }

                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped" style="width=100%">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>ID Item</th>";
                        echo "<th>Nama Item</th>";
                        echo "<th>Kategori</th>";
                        echo "<th>Harga</th>";
                        echo "<th>Edit</th>";
                        echo "<th>Delete</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_menu'] . "</td>";
                            echo "<td>" . $row['Nama'] . "</td>";
                            echo "<td>" . $row['kategori'] . "</td>";
                            echo "<td>" . $row['Harga'] . "</td>";
                            echo "<td>";
                            // Modify link with the pencil icon
                            $update_sql = "UPDATE products SET Nama=?, kategori=?, Harga=? WHERE id_menu=?";
                            echo '<a href="../admin/update-item.php?id_menu=' . $row['id_menu'] . '" title="Modify Record" data-toggle="tooltip"'
                                . 'onclick="return confirm(Apakah anda yakin ingin mengedit menu?\')">'
                                . '<i class="fa fa-pencil" aria-hidden="true"></i></a>';
                            echo "</td>";

                            echo "<td>";
                            $deleteSQL = "DELETE FROM products WHERE id_menu = '" . $row['id_menu'] . "';";
                            echo '<a href="../admin/delete-item.php?id_menu=' . $row['id_menu'] . '" title="Delete Record" data-toggle="tooltip" '
                                . 'onclick="return confirm(Apakah anda yakin ingin menghapus menu ini?\')"><span class="fa fa-trash text-black"></span></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Oops! Ada sesuatu yang gagal. Coba lagi.";
                }

                // Close connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include '../admin/dashFooter.php'; ?>