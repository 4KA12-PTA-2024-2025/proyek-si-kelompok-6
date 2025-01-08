// Buat variabel global untuk menyimpan nilai baru
var newValues = {};

function increaseQuantity(productName) {
  var quantityElement = document.getElementById("quantity_" + productName);
  var currentQuantity = parseInt(quantityElement.innerText);
  var newQuantity = currentQuantity + 1;

  var hargaProdukPerItem = hargaPerProdukArray[productName];
  var newTotalPrice = hargaProdukPerItem * newQuantity;

  // Simpan nilai baru ke dalam variabel global
  newValues[productName] = {
    newQuantity: newQuantity,
    newTotalPrice: newTotalPrice,
  };
  console.log(newValues);
  document.getElementById("newValuesInput").value = JSON.stringify(newValues);

  // Setel elemen quantity
  quantityElement.innerText = newQuantity;

  // Setel elemen total harga
  var totalElement = document.getElementById("total_" + productName);
  totalElement.innerHTML = formatCurrency(newTotalPrice);

  // Perbarui total harga
  updateTotalHarga();
}

function decreaseQuantity(productName) {
  var quantityElement = document.getElementById("quantity_" + productName);
  var currentQuantity = parseInt(quantityElement.innerText);

  // Menghindari penurunan jumlah di bawah 1
  if (currentQuantity > 0) {
    var newQuantity = currentQuantity - 1;
    var hargaProdukPerItem = hargaPerProdukArray[productName];
    var newTotalPrice = hargaProdukPerItem * newQuantity;

    // Simpan nilai baru ke dalam variabel global
    newValues[productName] = {
      newQuantity: newQuantity,
      newTotalPrice: newTotalPrice,
    };
    console.log(newValues);
    document.getElementById("newValuesInput").value = JSON.stringify(newValues);

    // Setel elemen quantity
    quantityElement.innerText = newQuantity;

    // Setel elemen total harga
    var totalElement = document.getElementById("total_" + productName);
    totalElement.innerHTML = formatCurrency(newTotalPrice);

    // Perbarui total harga
    updateTotalHarga();

    // Hapus item-container jika current quantity menjadi 0
    if (newQuantity === 0) {
      var itemContainer = document.getElementById("itemContainer_" + productName);
      if (itemContainer) {
        itemContainer.parentNode.removeChild(itemContainer);
      }
    }
  }
}

function updateTotalHarga() {
  // Dapatkan semua elemen dengan class 'hargaTotalProduk'
  var hargaTotalProdukElements = document.getElementsByClassName("hargaPerProduk");

  // Inisialisasi total harga
  var totalHarga = 0;

  // Iterasi melalui setiap elemen
  for (var i = 0; i < hargaTotalProdukElements.length; i++) {
    // Dapatkan harga per produk dari array yang disampaikan dari PHP
    var productName = hargaTotalProdukElements[i].id.split("_")[1];
    var hargaProdukPerItem = hargaPerProdukArray[productName];

    // Dapatkan elemen kuantitas dan total harga
    var quantityElement = document.getElementById("quantity_" + productName);
    var currentQuantity = parseInt(quantityElement.innerText);

    // Hitung total harga per produk
    var totalhargaTotalProduk = hargaProdukPerItem * currentQuantity;

    // Tambahkan ke total harga
    totalHarga += totalhargaTotalProduk;
  }

  // Hitung pajak berdasarkan total harga yang baru
  var taxPercentage = 11; // Persentase pajak
  var tax = (totalHarga * taxPercentage) / 100;

  var totalHargaFinal = totalHarga + tax;
  // Format totalHarga sebagai mata uang dan tambahkan "Rp" di depannya
  var formattedTotalHarga = "Rp " + totalHarga.toLocaleString("id-ID");

  // Perbarui tampilan total hargal :
  var totalHargaElement = document.getElementById("totalHarga");
  totalHargaElement.innerHTML = 'Subtotal <span style="white-space: pre;">                                                      </span>' + formattedTotalHarga;

  // Perbarui tampilan pajak dengan menggunakan ID
  var taxElementUpdate = document.getElementById("taxElement");
  taxElementUpdate.innerHTML = "Tax (" + taxPercentage + '%) <span style="white-space: pre;">                                                    </span> Rp ' + tax.toLocaleString("id-ID");

  //perbarui tampilan pajak setelah dihitung total harga menggunakan ID
  //MASUKAN NILAI KE FINAL HARGA
  var FinalHargaUpdate = document.getElementById("FinalHarga");
  FinalHargaUpdate.innerHTML = 'TOTAL <span style="white-space: pre;">                                          </span> Rp' + totalHargaFinal.toLocaleString("id-ID");
  document.getElementById("priceToPay").value = totalHargaFinal;

  console.log("harga final : ", totalHargaFinal);
}

// Fungsi untuk memformat mata uang
function formatCurrency(value) {
  // Modifikasi sesuai dengan kebutuhan Anda
  return "Rp " + number_format(value, 0, ",", ".");
}

// Fungsi untuk memformat angka sebagai mata uang
function number_format(number, decimals, decPoint, thousandsSep) {
  decimals = decimals || 0;
  number = parseFloat(number);

  var stringNumber = number.toFixed(decimals);

  var parts = stringNumber.split(".");
  var fnum = parts[0];
  var decimals = parts[1] ? (decPoint || ".") + parts[1] : "";

  return fnum.replace(/(\d)(?=(?:\d{3})+$)/g, "$1" + (thousandsSep || ",")) + decimals;
}

function prepareDataForSubmission() {
  // Mengumpulkan data dari setiap item dalam keranjang
  var products = {};
  var FinalHargaUpdate = document.getElementById("FinalHarga");

  $(".item-container").each(function () {
    var productName = $(this).find(".spanList").text().trim();
    var quantity = parseInt($(this).find(".quantity").text().trim());
    var hargaPerProduk = parseInt($(this).find(".hargaPerProduk").data("harga"));

    // Mengambil nilai newQuantity dan newTotalPrice dari variabel global newValues
    var newQuantity = newValues[productName] ? newValues[productName].newQuantity : quantity;
    var newTotalPrice = newValues[productName] ? newValues[productName].newTotalPrice : hargaPerProduk * quantity;

    products[productName] = {
      quantity: newQuantity,
      hargaPerProduk: hargaPerProduk,
      newTotalPrice: newTotalPrice,
    };
  });

  // Mengumpulkan data tambahan seperti nomor meja, nama pelanggan, dll.
  var tableNumber = $("#tableNumberDropdown").val();
  var customerName = $("#customerNameInput").val();
  var customerNumber = $("#customerNumberInput").val();
  var orderNote = document.getElementById("orderNote").value;

  // Mengambil nilai angka dari elemen dengan id 'FinalHarga'
  var totalHargaFinalText = $("#FinalHarga").text();
  var totalHargaFinal = parseInt(totalHargaFinalText.replace(/[^\d]/g, ""), 10);
  document.getElementById("priceToPay").value = totalHargaFinal;
  document.getElementById("orderNote").value = orderNote;

  if (!tableNumber || !customerName || !customerNumber) {
    alert('Semua kolom yang diperlukan harus diisi.');
    return;
}
  var payload = {
    products: products,
    totalHarga: totalHarga,
    totalHargaFinal: totalHargaFinal,
    tableNumber: tableNumber,
    customerName: customerName,
    customerNumber: customerNumber,
    orderNote: orderNote,
  };

  // Menetapkan nilai pada input tersembunyi
  $("#orderForm input[name='products']").val(JSON.stringify(payload.products));
  $("#orderForm input[name='totalHarga']").val(payload.totalHarga);
  $("#orderForm input[name='totalHargaFinal']").val(payload.totalHargaFinal);
  $("#orderForm input[name='tableNumber']").val(payload.tableNumber);
  $("#orderForm input[name='customerName']").val(payload.customerName);
  $("#orderForm input[name='customerNumber']").val(payload.customerNumber);
  $("#orderForm input[name='orderNote']").val(payload.orderNote);
  $("#orderForm input[name='newValues']").val(JSON.stringify(newValues));

  $("#orderForm").submit();

  console.log("Data yang dikirim:", payload);
  // Kirim data ke backend menggunakan AJAX (misalnya dengan Fetch API)
}
