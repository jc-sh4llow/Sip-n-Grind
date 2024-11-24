document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");
  const basketItemsContainer = document.getElementById("basket-items");
  const totalPriceElement = document.getElementById("total-price");
  let basket = {}; // Object to store basket items and their quantities

  // Get the menu item element and its price data attributes
  const menuItem = document.querySelector(".menu-item");
  const sizeSelector = document.getElementById("size-selector");
  const priceElement = document.getElementById("price");

  // Initial prices based on size
  let smallPrice = parseFloat(menuItem.getAttribute("data-small-price"));
  let mediumPrice = parseFloat(menuItem.getAttribute("data-medium-price"));
  let largePrice = parseFloat(menuItem.getAttribute("data-large-price"));

  // Function to update the displayed price and set the correct `data-price`
  function updatePrice() {
      const selectedSize = sizeSelector.value;
      let selectedPrice;
      switch (selectedSize) {
          case "small":
              selectedPrice = smallPrice;
              break;
          case "medium":
              selectedPrice = mediumPrice;
              break;
          case "large":
              selectedPrice = largePrice;
              break;
          default:
              selectedPrice = smallPrice;
      }

      // Update displayed price and `data-price` for the item
      priceElement.textContent = selectedPrice.toFixed(2);
      menuItem.setAttribute("data-price", selectedPrice);
  }

  // Update the price immediately when the size changes
  sizeSelector.addEventListener("change", updatePrice);

  // Function to update the total price in the basket
  function updateTotalPrice() {
      let totalPrice = Object.values(basket).reduce(
          (sum, item) => sum + item.quantity * item.price,
          0
      );
      totalPriceElement.textContent = totalPrice.toFixed(2);
  }

  // Function to render the basket
  function renderBasket() {
      basketItemsContainer.innerHTML = ""; // Clear existing items

      if (Object.keys(basket).length === 0) {
          basketItemsContainer.textContent = "Your basket is empty.";
          return;
      }

      for (let key in basket) {
          const { name, price, quantity, imgSrc, size } = basket[key];

          const basketItem = document.createElement("div");
          basketItem.className = "basket-item";

          // Product image
          const img = document.createElement("img");
          img.src = imgSrc;
          img.alt = name;

          // Product details
          const details = document.createElement("div");
          details.className = "basket-item-details";

          const itemName = document.createElement("h4");
          itemName.textContent = `${name} (${size})`;

          const itemPrice = document.createElement("p");
          itemPrice.textContent = `₱${price} x ${quantity}`;

          details.appendChild(itemName);
          details.appendChild(itemPrice);

          // Remove button
          const removeButton = document.createElement("button");
          removeButton.textContent = "Remove";
          removeButton.addEventListener("click", function () {
              basket[key].quantity -= 1; // Decrease quantity by 1
              if (basket[key].quantity <= 0) {
                  delete basket[key]; // Remove item if quantity is 0
              }
              renderBasket(); // Re-render the basket
              updateTotalPrice(); // Update the total price
          });

          basketItem.appendChild(img);
          basketItem.appendChild(details);
          basketItem.appendChild(removeButton);

          basketItemsContainer.appendChild(basketItem);
      }
  }

  // Event listeners for "Add to Basket" buttons
  addToCartButtons.forEach((button) => {
      button.addEventListener("click", function () {
          const menuItem = button.closest(".menu-item");
          const name = menuItem.getAttribute("data-name");
          const selectedSize = sizeSelector.value; // Get the selected size
          const selectedPrice = parseFloat(menuItem.getAttribute("data-price"));
          const imgSrc = menuItem.querySelector("img").src;

          // Ensure the price is valid (no NaN)
          if (isNaN(selectedPrice)) {
              console.error("Invalid price for item: " + name);
              return; // Exit if price is invalid
          }

          // Generate a unique key for the item based on name and size
          const itemKey = `${name}-${selectedSize}`;

          // Add or update the basket with the selected size and price
          if (basket[itemKey]) {
              basket[itemKey].quantity += 1; // Increment quantity if product already exists
          } else {
              basket[itemKey] = { name, size: selectedSize, price: selectedPrice, quantity: 1, imgSrc }; // Add new product to basket
          }

          renderBasket(); // Re-render the basket
          updateTotalPrice(); // Update the total price
      });
  });

  // Initialize the displayed price on page load
  updatePrice();
});
