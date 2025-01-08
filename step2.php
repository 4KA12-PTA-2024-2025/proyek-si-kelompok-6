<?php
session_start();
require_once('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $products = $_POST['products'];
  $totalHarga = $_POST['totalHarga'];
  $tableNumber = $_POST['tableNumber'];
  $customerName = $_POST['customerName'];
  $customerNumber = $_POST['customerNumber'];
  $priceToPay = $_POST['priceToPay'];
  $orderNote = $_POST['orderNote'];
  $totalHargaFinal = isset($_POST['totalHargaFinal']) ? $_POST['totalHargaFinal'] : 0;
  $orderNote = isset($_POST['orderNote']) ? $_POST['orderNote'] : '';
}

if (empty($tableNumber) || empty($customerName) || empty($customerNumber)) {
  die('Data nomor meja dan/atau informasi pelanggan harap diisi.');
}
// Ambil nilai newValues dari $_POST
$newValuesJSON = isset($_POST['newValues']) ? $_POST['newValues'] : '';

// Decode JSON menjadi array PHP
$newValuesArray = json_decode($newValuesJSON, true);
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Pindahkan console.log ke halaman baru
    console.log("Nilai totalHargaFinal di Step 2:", <?php echo json_encode($totalHargaFinal); ?>);
    // Sisanya dari skrip JavaScript yang mungkin ada di sini
  </script>
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
      <li class="step-wizard-item ">
        <span class="progress-count">1</span>
        <span class="progress-label">Detail Pesanan</span>
      </li>
      <li class="step-wizard-item current-item">
        <span class="progress-count">2</span>
        <span class="progress-label">Bayar di Kasir</span>
      </li>
    </ul>
  </section>

  <section class="summary" style="height:600px;">
    <div class="detail1-container">
      <div class="box">
        <h2>Detail Pesanan</h2>
        <?php
        // Menampilkan data di dalam detail-container
        $totalHarga = 0;

        foreach ($products as $productName => $productData) {
          $quantity = $productData['quantity'];
          $totalPrice = $productData['totalPrice'];
          $image = $productData['image'];


          $totalHarga += $totalPrice;

          $decodedProductName = urldecode(($productName));
          // Check apakah ada data baru untuk produk ini
          // Tambahkan bagian ini untuk menampilkan newValues
          if (isset($newValuesArray[$decodedProductName])) {
            $newValues = $newValuesArray[$decodedProductName];
            $newQuantity = $newValues['newQuantity'];
            $newTotalPrice = $newValues['newTotalPrice'];
          } else {
            $newQuantity = $productData['quantity'];
            $newTotalPrice = $productData['totalPrice'];
          }
          if ($newQuantity == 0) {
            continue;
          }

          // Mulai elemen item-container
          echo "<div class='items-container'>";

          // Gambar produk
          echo "<div class='product-image'>";
          echo "<img src='" . urldecode($image) . "' class='product-image'><br>";
          echo "</div>";

          // Detail produk dan harga
          echo "<div class='details-container'>";
          echo "<div class='spanList'>";
          echo "<b>" . urldecode(urldecode($productName)) . "<br>" . "</b>";
          echo "<span id='total_$productName'>Rp " . number_format($newTotalPrice, 0, ',', '.') . "</span><br>";
          echo "</div>";

          echo "<span class='quantity' id='quantity_$productName'>$newQuantity x</span><br>";
          // Selesai elemen details-container
          echo "</div>";

          // Selesai elemen item-container
          echo "</div>";
        }
        ?>
      </div>
    </div>

    <!--No table-->
    <div class="table1-container">
      <div class="table-box">
        <h2>No. Meja
          <hr>
        </h2>
        <input type="text" id="customerNameInput" id="tableNumberDropdown" name="tableNumber" value="<?php echo htmlspecialchars($tableNumber); ?>" readonly>
      </div>
    </div>

    <!--Notes-->
    <div class="note-container">
      <div class="note-box">
        <h2>Catatan Pelanggan
          <hr>
        </h2>
        <input type="text" id="customerNameInput" id="tableNumberDropdown" name="tableNumber" value="<?php echo htmlspecialchars($orderNote); ?>" readonly>
      </div>
    </div>

    <!--Informatipn customer-->
    <div class="cust1-container">
      <div class="cust-box">
        <h2>Informasi Pelanggan
          <hr>
        </h2>
        <input type="text" id="customerNameInput1" name="customerName" value="<?php echo htmlspecialchars($customerName); ?>" readonly>
        <input type="text" id="customerNumberInput1" name="customerNumber" value="<?php echo htmlspecialchars($customerNumber); ?>" readonly>
      </div>
    </div>

    <p class="come">Yuk, lihat menu kita lagi!</p>
    <div class="orderlagi">
      <div class='item-container'>
        <div class='product-image'>
          <img src="img\ayamgeprek.jpg" class='product-image'><br>
        </div>
        <div class='spanList'>
          <b><span>Ayam Geprek</span> <br></b>
          <span id='total_$productName'>Rp 17.000</span><br>
        </div>
      </div>
      <!--Cheese Pizza-->
      <div class='item-container'>
        <div class='product-image'>
          <img src="img\tehmanis.jpg" class='product-image'><br>
        </div>
        <div class='spanList'>
          <b> <span class="produkName">Es Teh Manis</span> <br> </b>
          <span id='total_$productName' class="produkName">Rp 4.000</span><br>
        </div>
      </div>
      <div class="pesan">
        <a href="home.php" class="bttm">Lihat Menu Lainnya</a>
      </div>
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
  <script src="js\script.js"></script>
  <script>
    console.log("Nilai totalHargaFinal di Step 2:", <?php echo json_encode($totalHargaFinal); ?>);

    // Menampilkan SweetAlert
    Swal.fire({
      title: "Pesanan Diterima!!",
      text: "Mohon menunggu! Silakan Anda bayar di Kasir",
      icon: "success",
    });
  </script>
</body>

</html>
<?php

// Inisialisasi array untuk menyimpan data pesanan
$pesananArray = [];

// Loop untuk memasukkan setiap produk ke dalam array
foreach ($_POST['products'] as $productName => $productData) {
  $quantity = $productData['quantity'];

  // Menyimpan data pesanan ke dalam array

  $decodedProductName = urldecode($productName);
  // Check apakah ada data baru untuk produk ini
  // Tambahkan bagian ini untuk menampilkan newValues
  if (isset($newValuesArray[$decodedProductName])) {
    $newValues = $newValuesArray[$decodedProductName];
    $newQuantity = $newValues['newQuantity'];
    $newTotalPrice = $newValues['newTotalPrice'];
  } else {
    $newQuantity = $productData['quantity'];
    $newTotalPrice = $productData['totalPrice'];
  }

  if ($newQuantity == 0) {
    continue;
  }
  $namaProduk = urldecode($decodedProductName);
  $pesananArray[] = " $namaProduk $newQuantity";
}

// Menggabungkan data pesanan menjadi satu baris
$pesanan = implode(", ", $pesananArray);

// Sesuaikan nama kolom dan nilai dengan struktur tabel yang sebenarnya di database
$sql = "INSERT INTO orders (pesanan,customer_name,customer_number,table_number,Total_Price,notes) VALUES ('$pesanan','$customerName','$customerNumber','$tableNumber','$priceToPay','$orderNote')";

// Eksekusi query SQL
if ($conn->query($sql) === TRUE) {
}

$conn->close();
?>