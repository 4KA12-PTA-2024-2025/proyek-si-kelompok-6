let search = document.querySelector(".search-box");

document.querySelector("#search-icon").onclick = () => {
  search.classList.toggle("active");
  navbar.classList.remove("active");
};

let navbar = document.querySelector(".navbar");

document.querySelector("#menu-icon").onclick = () => {
  navbar.classList.toggle("active");
  search.classList.remove("active");
};

window.onscroll = () => {
  navbar.classList.toggle("active");
  search.classList.remove("active");
};

let header = document.querySelector("header");

window.addEventListener("scroll", () => {
  header.classList.toggle("shadow", window.scrollY > 0);
});

/*cart muncul*/
let shoppingButton = document.querySelector(".shopping");
let closeShopping = document.querySelector(".closeShopping");
let list = document.querySelector(".list");
let body = document.querySelector("body");
let shopLogo = document.querySelector("bx bx-cart-alt");

shoppingButton.addEventListener("click", () => {
  if (body.classList.contains("active")) {
    body.classList.remove("active");
  } else {
    body.classList.add("active");
  }
});

closeShopping.addEventListener("click", () => {
  body.classList.remove("active");
});
