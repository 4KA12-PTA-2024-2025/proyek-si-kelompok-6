<?php 
session_start(); 
include '../admin/dashHeader.php'; 
?>
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
                    <h2 class="pull-left">Detail Akun</h2>
                </div>

                <div class="mb-3">
                    <form method="POST" action="#">
                        <div class="row">
                            <div class="col-md-6">
                                <input required type="text" id="search" name="search" class="form-control" placeholder="Enter Account ID/ username">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark">Cari</button>
                            </div>
                            <div class="col" style="text-align: right;">
                                <a href="account-panel.php" class="btn btn-light">Tampilkan Semua</a>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                // Include config file
                require_once "../koneksi.php";

                if (isset($_POST['search'])) {
                    if (!empty($_POST['search'])) {
                        $search = $_POST['search'];

                        $sql = "SELECT *
                                FROM akun
                                WHERE username LIKE '%$search%' OR id_akun LIKE '%$search%'
                                ORDER BY id_akun;";
                    } else {
                        // Default query to fetch all accounts
                        $sql = "SELECT *
                                FROM akun
                                ORDER BY id_akun;";
                    }
                } else {
                    // Default query to fetch all accounts
                    $sql = "SELECT *
                            FROM akun
                            ORDER BY id_akun;";
                }

                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table class="table table-bordered table-striped">';
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>Account ID</th>";
                        echo "<th>Nama</th>";
                        echo "<th>Username</th>";
                        echo "<th>Email</th>";
                        echo "<th>Waktu Pendaftaran</th>";
                        // echo "<th>Delete</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_akun'] . "</td>";
                            echo "<td>" . $row['nama'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['timestamp'] . "</td>";
                            //  echo "<td>";
                            //  $deleteSQL = "DELETE FROM Accounts WHERE id_akun = '" . $row['id_akun'] . "';";
                            // echo '<a href="../accountCrud/deleteAccountVerify.php?id_akun=' . $row['id_akun'] . '" title="Delete Record" data-toggle="tooltip" '
                            //         . 'onclick="return confirm(\'Admin permission Required!\n\nAre you sure you want to delete this Account?\n\nThis will alter other modules related to this Account!\n\')"><span class="fa fa-trash text-black"></span></a>';
                            // echo "</td>";
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
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close connection
                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include '../admin/dashFooter.php'; ?>