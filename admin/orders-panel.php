<?php
session_start();
?>
<?php include '../admin/dashHeader.php'; ?>
<style>
    .wrapper {
        width: 85%;
        padding-left: 200px;
        padding-top: 20px;
    }
</style>

<div class="wrapper">
    <div class="container-fluid pt-5 pl-600">
        <div class="row">
            <div class="m-50">
                <div class="mt-5 mb-3">
                    <h2 class="pull-left">Daftar Pesanan</h2>
                </div>

                <?php
                // Include config file
                require_once "../koneksi.php";

                // Handle status change
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id']) && isset($_POST['status'])) {
                    $order_id = $_POST['order_id'];
                    $status = $_POST['status'];

                    $update_sql = "UPDATE orders SET status = ? WHERE id = ?";
                    if ($stmt = mysqli_prepare($conn, $update_sql)) {
                        mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
                        if (mysqli_stmt_execute($stmt)) {
                            echo '<div class="alert alert-success"><em>Status pesanan berhasil diubah.</em></div>';
                        } else {
                            echo '<div class="alert alert-danger"><em>Terjadi kesalahan. Mohon coba lagi.</em></div>';
                        }
                    }
                    mysqli_stmt_close($stmt);
                }

                // Handle reset all orders
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset_all_orders'])) {
                    $delete_all_sql = "DELETE FROM orders";
                    if (mysqli_query($conn, $delete_all_sql)) {
                        echo '<div class="alert alert-success"><em>Semua data pesanan berhasil dihapus.</em></div>';
                    } else {
                        echo '<div class="alert alert-danger"><em>Terjadi kesalahan saat menghapus data pesanan.</em></div>';
                    }
                }

                $sql = "SELECT * FROM orders";

                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped" style="width:100%">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Bill ID</th>";
                        echo "<th>Pickup Time</th>";
                        echo "<th>Customer Name</th>";
                        echo "<th>Phone Number</th>";
                        echo "<th>Timestamp</th>";
                        echo "<th>Pesanan</th>";
                        echo "<th>Total Harga</th>";
                        echo "<th>Notes</th>";
                        echo "<th>Status</th>";
                        echo "<th>Actions</th>";
                        echo "<th>WhatsApp</th>"; // Kolom baru untuk WhatsApp
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            $phone = $row['customer_number']; // Nomor HP pelanggan
                            $message = urlencode("Halo " . $row['customer_name'] . ", terimakasih sudah memesan di Warung Boboko. Pesanan Anda adalah " . $row['pesanan'] . " dengan detail '" . $row['notes'] . "'. Total harga pesanan Anda adalah Rp" . $row['Total_Price'] .     ". Harap mengirim bukti pembayaran melalui chat ini. Terimakasih."); // Pesan dengan data dinamis
                
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['table_number'] . "</td>";
                            echo "<td>" . $row['customer_name'] . "</td>";
                            echo "<td>" . $phone . "</td>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            echo "<td>" . $row['pesanan'] . "</td>";
                            echo "<td>" . $row['Total_Price'] . "</td>";
                            echo "<td>" . $row['notes'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>";
                            
                            // Tombol untuk mengubah status
                            echo '<form method="POST" action="" style="display:inline-block;">';
                            echo '<input type="hidden" name="order_id" value="' . $row['id'] . '">';
                            if ($row['status'] == 'Pending') {
                                echo '<button type="submit" name="status" value="Dikonfirmasi" class="btn btn-warning">Dikonfirmasi</button>';
                            }
                            if ($row['status'] == 'Dikonfirmasi') {
                                echo '<button type="submit" name="status" value="Selesai" class="btn btn-success">Selesai</button>';
                            }
                            echo '</form>';
                            echo "</td>";
                            
                            // Kolom baru untuk WhatsApp
                            echo "<td>";
                            echo '<a href="https://wa.me/62' . $phone . '?text=' . $message . '" target="_blank" class="btn btn-secondary">WA</a>';
                            echo "</td>";
                            
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    echo "Oops! Ada sesuatu yang salah. Mohon coba nanti lagi.";
                }
                
                

                // Close connection
                mysqli_close($conn);
                ?>

                <div class="mt-3 mb-3">
                    <form method="POST" action="">
                        <button type="submit" name="reset_all_orders" onclick="return confirm('Anda yakin ingin menghapus semua data pesanan?')" class="btn btn-danger">Reset Semua Pesanan</button>
                    </form>
                </div>

                <div class="mt-3 mb-3">
                    <form action="export_pdf.php" method="post">
                        <button type="submit" class="btn btn-primary">Cetak PDF</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../admin/dashFooter.php'; ?>