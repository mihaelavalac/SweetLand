let addCartItemBtn = document.querySelectorAll(".add-cart-item");
let removeCartItemBtn = document.querySelectorAll(".remove-cart-item");
let placeOrderBtn = document.querySelector("#place-order");
let cartNotificationEl = document.querySelector(".card-notification");
let cartEl = document.querySelector("#shopping-cart");
let cartItemQuantityEl = document.querySelectorAll(".card-item-quantity");

let finalCartItemQuantityEl = document.querySelectorAll(
  ".final-card-item-quantity"
);
let totalPriceEl = document.querySelectorAll(".total-price");

if (addCartItemBtn) {
  addCartItemBtn.forEach((elem) =>
    elem.addEventListener("click", function (evt) {
      let event = evt.target;
      handleAddToCartButton(event);
    })
  );
}

if (removeCartItemBtn) {
  removeCartItemBtn.forEach((elem) =>
    elem.addEventListener("click", function (evt) {
      let event = evt.target;
      handleRemoveCartItem(event);
    })
  );
}

if (window.location.pathname.includes("shopping_cart.php")) {
  if (placeOrderBtn) {
    placeOrderBtn.addEventListener("click", function () {
      let orders = localStorage.getItem("cartItems");
      if (orders) {
        window.location.href = "./orders_handler.php?orders=" + orders;
        return;
      }
    });
  }
  displayTotalPrice(returnTotalPrice());
  displayMenuItemsQuantity();
}

if(cartItemQuantityEl){
  cartItemQuantityEl.forEach((elem) =>
  elem.addEventListener("change", function () {
    let id = elem.dataset.id;
    let quantity = elem.value;
    let price = elem.dataset.price;
    updateLSQuantity(id, quantity);
    let totalPrice = returnTotalPrice();
    displayTotalPrice(totalPrice);
  })
);
}


function updateLSQuantity(id, quantity) {
  let currentItems = JSON.parse(localStorage.getItem("cartItems"));
  if (currentItems == "" || currentItems == null || currentItems.length == 0) {
    return;
  } else {
    for (let i = 0; i < currentItems.length; i++) {
      if (currentItems[i][0] == id) {
        currentItems[i][1] = quantity;
      }
    }
  }
  localStorage.setItem("cartItems", JSON.stringify(currentItems));
  setCartItemsNumber();
  //displayTotalPrice(returnTotalPrice());
  displayMenuItemsQuantity();
}


if(addCartItemBtn){
    addCartItemBtn.forEach((elem) => {
      let itemId = elem.getAttribute("data-id");
      let currentItems = JSON.parse(localStorage.getItem("cartItems"));
      for (let i = 0; i < currentItems.length; i++) {
        if (currentItems[i][0] == itemId) {
          elem.innerHTML = "Remove from cart";
          break;
        } else {
          elem.innerHTML = "Add to cart";
        }
      }
    });
    setCartItemsNumber();
    // if in shopping cart
    displayTotalPrice(returnTotalPrice());
    displayMenuItemsQuantity();
}
  


function displayMenuItemsQuantity() {
  finalCartItemQuantityEl.forEach((elem) => {
    let itemId = elem.getAttribute("data-id");
    let currentItems = JSON.parse(localStorage.getItem("cartItems"));
    for (let i = 0; i < currentItems.length; i++) {
      if (currentItems[i][0] == itemId) {
        elem.innerHTML = currentItems[i][1];
        break;
      }
    }
  });

  cartItemQuantityEl.forEach((elem) => {
    let itemId = elem.getAttribute("data-id");
    let currentItems = JSON.parse(localStorage.getItem("cartItems"));
    for (let i = 0; i < currentItems.length; i++) {
      if (currentItems[i][0] == itemId) {
        elem.value = currentItems[i][1];
        break;
      }
    }
  });
}

if(cartEl){
  cartEl.addEventListener("click", function () {
    accessCartItemURL();
  });
  
}

function displayTotalPrice(price) {
  if (totalPriceEl) {
    totalPriceEl.forEach((elem) => {
      elem.innerText = "$" + price;
    });
  }
}

// return total price from card elements
function returnTotalPrice() {
  let totalPrice = 0;
  cartItemQuantityEl.forEach((elem) => {
    let itemId = elem.dataset.id;
    let price = elem.dataset.price;
    let quantity = 1;
    let currentItems = JSON.parse(localStorage.getItem("cartItems"));
    for (let i = 0; i < currentItems.length; i++) {
      if (currentItems[i][0] == itemId) {
        quantity = currentItems[i][1];
        break;
      }
    }
    totalPrice += parseInt(quantity) * parseInt(price);
  });

  return totalPrice.toFixed(2);
}

function accessCartItemURL() {
  let ids = getCartItemIds();
  if (ids) {
    window.location.href = "./shopping_cart.php?ids=" + JSON.stringify(ids);
    return;
  } else {
    window.location.href = "./shopping_cart.php";
  }
}

function handleAddToCartButton(event) {
  if (event.innerHTML == "Remove from cart") {
    removeItemFromCart(event.dataset.id);
    event.innerHTML = "Add to cart";
  } else {
    addCartItemToLS(event.dataset.id);
    event.innerHTML = "Remove from cart";
  }
}

function handleRemoveCartItem(event) {
  removeItemFromCart(event.dataset.id);
  accessCartItemURL();
}

function addCartItemToLS(id) {
  let currentItems = JSON.parse(localStorage.getItem("cartItems"));
  if (currentItems == "" || currentItems == null) {
    currentItems = [];
  } else {
    for (let i = 0; i < currentItems.length; i++) {
      if (currentItems[i][0] == id) {
        return;
      }
    }
  }

  currentItems.push([id, 1]);
  localStorage.setItem("cartItems", JSON.stringify(currentItems));
  setCartItemsNumber();
}

function removeItemFromCart(id) {
  let currentItems = JSON.parse(localStorage.getItem("cartItems"));
  currentItems = currentItems.filter(function (item) {
    return item[0] !== id;
  });
  localStorage.setItem("cartItems", JSON.stringify(currentItems));
  setCartItemsNumber();
}

function getCartItemsNumber() {
  let cartItemsLength = JSON.parse(localStorage.getItem("cartItems")).length;
  if (!cartItemsLength) {
    return 0;
  } else if (cartItemsLength > 9) {
    return "*";
  }
  return cartItemsLength;
}

function getCartItemIds() {
  let cartItems = JSON.parse(localStorage.getItem("cartItems"));
  cartItemIds = "";
  for (let i = 0; i < cartItems.length; i++) {
    cartItemIds += cartItems[i][0];
    if (!(i == cartItems.length - 1)) {
      cartItemIds += ",";
    }
  }
  if (cartItems == "" || cartItems == null || cartItems.length == 0) {
    return null;
  }
  return cartItemIds;
}

function setCartItemsNumber() {
  if (getCartItemsNumber()) {
    cartNotificationEl.innerHTML = getCartItemsNumber();
  } else {
    cartNotificationEl.innerHTML = 0;
  }
}
