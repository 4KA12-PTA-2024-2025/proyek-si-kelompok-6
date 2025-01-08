<?php
$cartItems = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['products'])) {
  $cartItems = $_GET['products'];
}
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
  <!--Navbar-->
  <header class="products">
    <a href="home.php" class="logo">
      <img src="img\logo.png" alt="" style="position:relative; top: 15px;">
      <h2 style="margin-bottom: 15px;">Warung Boboko</h2>
    </a>
  </header>

  <!--Step progress-->
  <section class="step-wizard">
    <ul class="step-wizard-list">
      <li class="step-wizard-item current-item">
        <span class="progress-count">1</span>
        <span class="progress-label">Detail pesanan</span>
      </li>
      <li class="step-wizard-item current-item">
        <span class="progress-count">2</span>
        <span class="progress-label">Bayar di kasir</span>
      </li>
    </ul>
  </section>

  <section class="summary">
    <div class="container-row">
      <div class="detail-container">
        <div class="box">
          <h2>Detail Pesanan</h2>
          <br>

          <?php
          $totalHarga = 0;
          foreach ($cartItems as $productName => $productData) {
            $quantity = $productData['quantity'];
            $totalPrice = $productData['totalPrice'];
            $image = $productData['image'];

            // Skip jika quantity adalah 0
            if ($quantity == 0) {
              continue;
            }
            $totalHarga += $totalPrice;
            // Menghindari pembagian dengan nol
            $hargaProdukPerItem = ($quantity > 0) ? $totalPrice / $quantity : 0;
            // Menyimpan harga per produk ke dalam array
            $hargaPerProdukArray[$productName] = $hargaProdukPerItem;
            // Mulai elemen item-container
            echo "<div class='item-container' id='itemContainer_$productName'>";

            // Gambar produk
            echo "<div class='product-image'>";
            echo "<img src='" . urldecode($image) . "' class='product-image'><br>";
            echo "</div>";

            // Detail produk dan harga
            echo "<div class='details-container'>";
            echo "<div class='spanList'>";
            echo "<b>" . urldecode($productName) . "</b><br>";
            echo "<span id='total_$productName'>Rp " . number_format($totalPrice, 0, ',', '.') . "</span><br>";
            echo "</div>";

            // Tombol decrease dan increase

            echo "<button id='minButton_$productName' class='minButton' onclick='decreaseQuantity(\"$productName\", $totalPrice)'>-</button>";
            echo "<span class='quantity' id='quantity_$productName'>$quantity</span>";
            echo "<button id='plusButton_$productName' class='plusButton' onclick='increaseQuantity(\"$productName\", $totalPrice)'>+</button>";
            echo "<span id='hargaTotalProduk_$productName' class='hargaTotalProduk' data-harga='$totalPrice' style='display: none;'></span>";
            echo " <span class='hargaPerProduk' id='hargaPerProduk_$productName' data-harga='$hargaProdukPerItem'></span>";

            // Selesai elemen details-container
            echo "</div>";

            // Selesai elemen item-container
            echo "</div>";
          }
          ?>
        </div>
      </div>

      <!--Total-->
      <div class="total-container">
        <div class="total-box">
          <h2>Total Pembayaran
            <hr>
          </h2>
          <?php
          // Menampilkan total harga di dalam detail-container
          echo "<div id='totalHarga' class='total-harga'>";
          echo "Subtotal " . " &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;" . "Rp " . number_format($totalHarga, 0, ',', '.') . "<br>";
          echo "</div>";
          ?>

          <div class="tax">
            <?php
            // Mendapatkan total harga dari data PHP Anda
            // Hitung pajak berdasarkan total harga yang baru
            $taxPercentage = 11; // Persentase pajak
            $tax = ($totalHarga * $taxPercentage) / 100;

            // Format totalHarga sebagai mata uang dan tambahkan "Rp" di depannya
            $formattedTotalHarga = number_format($totalHarga + $tax, 0, ',', '.');
            $formattedTax = number_format($tax, 0, ',', '.');

            // Menampilkan pajak
            echo "<div class='tax' id='taxElement'>";
            echo "Tax ({$taxPercentage}%) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                     Rp {$formattedTax}<br>";
            echo "</div>";
            // Menampilkan total harga setelah pajak
            echo "<div class='total-harga-setelah-pajak' id='setelahPajak'>";
            //echo "<br>Total Harga (Setelah Pajak): Rp {$formattedTotalHarga} <br>";
            echo "</div>";
            echo "<hr>";
            echo "<div class='FinalHarga' id='FinalHarga' style='font-size: 20px'>";
            echo "TOTAL <span style='white-space: pre;'>                                    </span>Rp {$formattedTotalHarga}";
            echo "</div>"
            ?>
          </div>
        </div>
      </div>
    </div>

    <!--No table-->
    <div class="container-row">
      <div class="table-container">
        <div class="table-box">
          <h2>Nomor Meja
            <hr>
          </h2>
          <h4>Pilih nomor meja</h4>
          <select id="tableNumberDropdown" required>
            <option value="" disabled selected>Pilih nomor meja</option>

            <?php
            for ($i = 1; $i <= 7; $i++) {
              echo "<option value='{$i}'>{$i}</option>";
            }
            ?>
          </select>
        </div>
      </div>

      <!-- Informati0n customer -->
      <div class="cust-container">
        <div class="cust-box">
          <h2>Informasi Pelanggan
            <hr>
          </h2>
          <input type="text" id="customerNameInput" name="customerName" placeholder="Name" required>
          <input type="text" id="customerNumberInput" name="customerNumber" placeholder="Phone Number" required>
        </div>
      </div>

      <div class="cust-container">
        <div class="cust-box">
          <h2>Catatan pesanan
            <hr>
          </h2>
          <input type="text" id="orderNote" name="orderNote" placeholder="Masukkan catatan apabila ada" style="height:100px;">
        </div>
      </div>
    </div>

    <!--Button-->
    <div class="button-pay">
      <button type="button" class="btn btn-success" onclick="prepareDataForSubmission()">Bayar</button>
    </div>

    <form id="orderForm" action="step2.php" method="POST">
      <?php foreach ($cartItems as $productName => $productData) { ?>
        <input type="hidden" name="products[<?php echo urlencode($productName); ?>][quantity]" value="<?php echo $productData['quantity']; ?>">
        <input type="hidden" name="products[<?php echo urlencode($productName); ?>][totalPrice]" value="<?php echo $productData['totalPrice']; ?>">
        <input type="hidden" name="products[<?php echo urlencode($productName); ?>][image]" value="<?php echo $productData['image']; ?>">
        <input type="hidden" name="newValues" id="newValuesInput" value="<?php echo json_encode($newValuesArray); ?>">
      <?php } ?>

      <input type="hidden" name="totalHarga" value="<?php echo $totalHarga; ?>">
      <input type="hidden" name="tableNumber" id="tableNumber" value="">
      <input type="hidden" name="customerName" id="customerName" value="">
      <input type="hidden" name="customerNumber" id="customerNumber" value="">
      <input type="hidden" name="priceToPay" id="priceToPay" value="">
      <input type="hidden" name="orderNote" id="orderNote" value="">
    </form>
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
  <script src="js/step1.js"></script>
  <script>
    $('.dropdown-menu').click(function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).toggleClass('expan');
      $("#" + $(e.target).attr('for')).prop('checked', true);
    })

    $(document).click(function() {
      $('.dropdown-menu').removeClass('expan');
    });

    var hargaPerProdukArray = <?php echo json_encode($hargaPerProdukArray); ?>;
  </script>
</body>

</html>