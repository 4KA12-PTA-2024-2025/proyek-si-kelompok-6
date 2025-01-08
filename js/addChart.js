document.addEventListener("DOMContentLoaded", function () {
  const cartList = document.querySelector(".listCard");
  const quantityElement = document.querySelector(".quantity");
  const orderNowButton = document.querySelector(".orderNow");
  let cartItems = JSON.parse(localStorage.getItem("cartItems")) || {};
  let totalHarga = calculateTotalHarga(cartItems);

  const form = document.createElement("form");
  form.action = "step1.php";
  form.method = "get";

  orderNowButton.addEventListener("click", function () {
    // Mendapatkan data dari cartItems
    Object.entries(cartItems).forEach(([productName, { quantity, totalPrice, image }]) => {
      const inputQuantity = document.createElement("input");
      inputQuantity.type = "hidden";
      inputQuantity.name = `products[${encodeURIComponent(productName)}][quantity]`;
      inputQuantity.value = quantity;
      form.appendChild(inputQuantity);

      const inputTotalPrice = document.createElement("input");
      inputTotalPrice.type = "hidden";
      inputTotalPrice.name = `products[${encodeURIComponent(productName)}][totalPrice]`;
      inputTotalPrice.value = totalPrice;
      form.appendChild(inputTotalPrice);

      const inputImage = document.createElement("input");
      inputImage.type = "hidden";
      inputImage.name = `products[${encodeURIComponent(productName)}][image]`;
      inputImage.value = image;
      form.appendChild(inputImage);
    });

    // Menambahkan form ke dalam dokumen dan mengirimkannya
    document.body.appendChild(form);
    form.submit();

    // Setelah pengiriman form, hapus data keranjang belanja dari localStorage
    localStorage.removeItem("cartItems");
    // Atau, jika Anda ingin menyimpan data keranjang setelah pengiriman form, Anda bisa menggunakan:
    // cartItems = {};
    // localStorage.setItem("cartItems", JSON.stringify(cartItems));
  });

  function calculateTotalHarga(cartItems) {
    return Object.values(cartItems).reduce((total, { totalPrice }) => total + totalPrice, 0);
  }

  function addToCart(productName, productPrice, productImg) {
    if (cartItems[productName] === undefined) {
      cartItems[productName] = {
        quantity: 1,
        totalPrice: productPrice,
        image: productImg,
      };
    } else {
      cartItems[productName].quantity++;
      cartItems[productName].totalPrice += productPrice;
    }

    totalHarga = calculateTotalHarga(cartItems);

    renderCart();

    localStorage.setItem("cartItems", JSON.stringify(cartItems));
  }

  function renderCart() {
    cartList.innerHTML = "";
    let totalQuantity = 0;

    for (let item in cartItems) {
      if (cartItems[item].quantity > 0) {
        const listItem = document.createElement("li");

        const itemContainer = document.createElement("div");
        itemContainer.classList.add("item-container");

        const productImg = document.createElement("img");
        productImg.src = cartItems[item].image;
        productImg.classList.add("product-image");
        itemContainer.appendChild(productImg);

        const detailsContainer = document.createElement("div");
        detailsContainer.classList.add("details-container");

        const itemText = document.createElement("div");
        itemText.classList.add("spanList");
        itemText.innerHTML = `<b>${item}</b>`;
        detailsContainer.appendChild(itemText);

        const hargaText = document.createElement("div");
        hargaText.classList.add("spanList");
        hargaText.innerHTML = `Rp ${cartItems[item].totalPrice.toLocaleString("id-ID")}`;
        detailsContainer.appendChild(hargaText);

        const decreaseButton = document.createElement("button");
        decreaseButton.classList.add("minButton");
        decreaseButton.textContent = "-";
        decreaseButton.addEventListener("click", () => decreaseQuantity(item));
        detailsContainer.appendChild(decreaseButton);

        const quantityText = document.createElement("span");
        quantityText.textContent = ` ${cartItems[item].quantity} `;
        detailsContainer.appendChild(quantityText);

        const increaseButton = document.createElement("button");
        increaseButton.classList.add("plusButton");
        increaseButton.textContent = "+";
        increaseButton.addEventListener("click", () => increaseQuantity(item));
        detailsContainer.appendChild(increaseButton);

        itemContainer.appendChild(detailsContainer);

        listItem.appendChild(itemContainer);
        cartList.appendChild(listItem);

        totalQuantity += cartItems[item].quantity;
      }
    }

    const totalHargaElement = document.createElement("li");
    const hrElement = document.createElement("hr");
    hrElement.classList.add("hrCart");
    totalHargaElement.classList.add("total-harga");
    totalHargaElement.innerHTML = `TOTAL: <span class="totalListCart"> Rp ${totalHarga.toLocaleString("id-ID")}</span>`;
    cartList.appendChild(hrElement);
    cartList.appendChild(totalHargaElement);
    quantityElement.textContent = totalQuantity;
  }

  function decreaseQuantity(productName) {
    const hargaProdukPerItem = cartItems[productName].totalPrice / cartItems[productName].quantity;

    cartItems[productName].quantity--;
    cartItems[productName].totalPrice -= hargaProdukPerItem;
    totalHarga = calculateTotalHarga(cartItems);
    renderCart();
  }

  function increaseQuantity(productName) {
    const hargaProdukPerItem = cartItems[productName].totalPrice / cartItems[productName].quantity;

    cartItems[productName].quantity++;
    cartItems[productName].totalPrice += hargaProdukPerItem;
    totalHarga = calculateTotalHarga(cartItems);
    renderCart();
  }

  const addToCartButtons = document.querySelectorAll("a[href='#']");
  addToCartButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      const productContainer = event.target.closest(".box");
      const productName = productContainer.querySelector("h3").textContent;
      const productPrice = parseFloat(productContainer.querySelector("span").textContent.replace("Rp ", "").replace(".", "").replace(",", "."));
      const productImg = productContainer.querySelector("img").src;
      addToCart(productName, productPrice, productImg);
    });
  });

  renderCart();
});
