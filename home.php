<?php
session_start();
require_once('koneksi.php');

$sql_categories = "SELECT DISTINCT kategori FROM products";
$result_categories = $conn->query($sql_categories);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Warung Boboko</title>
    <!--Link CSS-->
    <link rel="stylesheet" href="css\style.css">
    <!--Box Icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <script src="js/addChart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/ajax.js"></script>

</head>

<body>
    <!--Navbar-->
    <header class="products">
        <a href="home.php" class="logo">
            <div class="img-logo">
                <img src="img\logo.png" alt="" style="position: relative; top: 8px;">
            </div>
            <h2 style="margin-bottom: 15px;">Warung Boboko</h2>
        </a>
        <!--Menu Icon-->
        <i class='bx bx-menu' id="menu-icon"></i>
        <!--Icon-->
        <div class="header-icon">
            <div class="shopping">
                <i class="bx bx-cart-alt"></i>
                <span class="quantity">0</span>
            </div>
            <i class="bx bx-search" id="search-icon"></i>
        </div>
        <!--search box-->
        <div class="search-box">
            <input type="text" name="" id="searchInput" placeholder="Search Here" />
            <div id="searchResults"></div>
        </div>
        <button onclick="redirectToLogout()" class="btn btn-outline-secondary text-end" style="border: 3px solid #607274; margin-right: 10px; font-weight: bold; cursor:pointer; padding: 8px 15px; margin-top: 5px; margin-right: 2px; background-color: #607274">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0z" />
                <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
            </svg>
            Logout
        </button>
    </header>

    <div class="list">

    </div>
    <!--Add to Cart card-->
    <div class="card">
        <h1>Your Cart</h1>
        <ul class="listCard">
        </ul>
        <div class="checkOut">
            <div class="orderNow">
                <h3 style="color: #fff">Order</h3>
            </div>
            <div class="closeShopping">Close</div>
        </div>
    </div>

    <!--Products-->
    <section class="home">
        <div class="home-img" style="margin-right: 150px; margin-top: 10px; width: 45%;">
            <img src="img\hello.png" class="img" width="200" />
        </div>
        <div class="sapa" style="margin-left: 460px; position: relative; top: -360px">
            <h3 style="font-weight: bold; top: 50px; color: #607274">Hola!</h3>
            <h2 style="font-weight: bold">Makanan Lezat, Pesan Mudah.</h2>
            <h4 style="font-size: 20px">Yuk, langsung aja pesan disini!</h4>
            <button onclick="goToHalaman()" class="btn-pesan" style="border-radius: 5px; cursor: pointer; background-color: #fff; color: #607274; border: 3px solid #607274; padding: 10px 15px; font-weight: bold; margin-top: 10px">Pesan yuk!</button>
        </div>
    </section>

    <section class="products" id="products" style="position: relative; top: -10px; height: 1000px; background-image: url(img/bg-menu.png); background-size: cover; padding: 0 10px; overflow-y: scroll;">
        <div class="heading" style="font-size: 18px; text-transform: uppercase; text-align: center; line-height: 1; padding-top: 10px;">
            <h1 style="color: #fff;">Menu Kami</h1>
        </div>

        <!--Tabs-->
        <ul class="nav nav-tabs">
            <?php
            mysqli_data_seek($result_categories, 0);
            if ($result_categories->num_rows > 0) {
                while ($row_category = $result_categories->fetch_assoc()) {
                    $kategori = $row_category['kategori'];
                    echo '<li class="nav-item">';
                    echo '<a class="nav-link" data-toggle="tab" href="#' . $kategori . '">' . $kategori . '</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>

        <div class="tab-content">
            <?php
            mysqli_data_seek($result_categories, 0);
            if ($result_categories->num_rows > 0) {
                while ($row_category = $result_categories->fetch_assoc()) {
                    $kategori = $row_category['kategori'];
                    echo '<div id="' . $kategori . '" class="tab-pane fade">';
                    echo '<div class="products-container">';

                    // Query to fetch products based on category
                    $sql_products = "SELECT * FROM products WHERE kategori = '$kategori'";
                    $result_products = $conn->query($sql_products);

                    if ($result_products->num_rows > 0) {
                        while ($row_product = $result_products->fetch_assoc()) {
                            echo '<div class="box" id="' . $row_product['id_menu'] . '">';
                            echo '<img src="img/' . $row_product['gambar'] . '" alt="' . $row_product['Nama'] . '">';
                            echo '<h3>' . $row_product['Nama'] . '</h3>';
                            echo '<div class="content">';
                            echo '<span>Rp ' . number_format($row_product['Harga'], 0, ',', '.') . '</span>';
                            echo '<a href="#">Tambah ke Troli</a>';
                            echo '</div></div>';
                        }
                    } else {
                        echo "Produk tidak ditemukan";
                    }
                    echo '</div></div>';
                }
            }
            ?>
        </div>
    </section>

    <footer>
        <div class="footer-container" style="background-color: #fff; margin-top: 10px; color: #54595a; padding: 30px">
            <div class="row" style="gap: 20px">
                <div class="col-md-6 col-lg-6 col-sm-12">
                    <h3 style="font-weight: bold; color:#28334a;">Kontak Kami</h3>
                    <p style="font-size: 16px; font-weight: 500">Jl.Pamaan Rt/Rw.001/009 Kel.Tugu Kec.Cimanggis, Tugu, Kec. Cimanggis, Kota Depok, Jawa Barat 16451<br />085310000932</p>
                </div>
            </div>
        </div>
        <div class="footer-bottom" style="background-color: #28334a; color: #fff; padding: 10px 30px; text-align: center">&copy; 2024 Warung Boboko. All Rights Reserved.</div>
    </footer>


    <!--Script to JS-->
    <script src="js/script.js"></script>
    <script src="js/ajax.js"></script>
    <script src="js/addChart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        function redirectToLogout() {
            window.location.href = "index.php";
        }

        function goToHalaman() {
            window.location.href = "#products";
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Panggil fungsi displayContent dengan ID konten makanan
            displayContent(null, "makanan");
        });
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 1800000); // 1800000 ms = 30 menit

        function displayContent(event, contentNameID) {
            let content = document.getElementsByClassName("contentClass");
            let totalCount = content.length;

            for (let count = 0; count < totalCount; count++) {
                content[count].style.display = "none";
            }

            let links = document.getElementsByClassName("linkClass");
            totalLinks = links.length;

            for (let count = 0; count < totalLinks; count++) {
                links[count].classList.remove("active");
            }

            document.getElementById(contentNameID).style.display = "block";

            event?.currentTarget.classList.add("active"); // Menambahkan kelas "active" pada link yang dipilih jika event tidak null
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Periksa jika terdapat fragment identifier pada URL (ID produk)
            if (window.location.hash) {
                var targetId = window.location.hash.substring(1); // Menghapus karakter '#' di awal fragment identifier
                var targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Elemen dengan ID yang sesuai ditemukan
                    // Tambahkan efek atau animasi yang Anda inginkan
                    targetElement.classList.add("highlight", "animate-highlight");

                    // Buat penundaan (misalnya, 2 detik) untuk menghilangkan efek highlight
                    setTimeout(function() {
                        targetElement.classList.remove("animate-highlight");
                    }, 2000);
                }
            }
        });
    </script>
</body>

</html>