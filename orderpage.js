document.addEventListener("DOMContentLoaded", function () {
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const basketItemsContainer = document.getElementById("basket-items");
    const totalPriceElement = document.getElementById("total-price");
  
    let basket = {}; // Object to store basket items and their quantities
  
    // Function to update the total price
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
        const { name, price, quantity, imgSrc } = basket[key];
  
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
        itemName.textContent = name;
  
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
        const itemId = menuItem.getAttribute("data-id");
        const name = menuItem.getAttribute("data-name");
        const price = parseFloat(menuItem.getAttribute("data-price"));
        const imgSrc = menuItem.querySelector("img").src;
  
        if (basket[itemId]) {
          basket[itemId].quantity += 1; // Increment quantity if product already exists
        } else {
          basket[itemId] = { name, price, quantity: 1, imgSrc }; // Add new product to basket
        }
  
        renderBasket(); // Re-render the basket
        updateTotalPrice(); // Update the total price
      });
    });
    checkoutButton.addEventListener("click", function () {
      if (Object.keys(basket).length === 0) {
        alert("Your basket is empty!");
        return;
      }

      // Send the basket data to the server
      fetch("checkout.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(basket), // Send basket data as JSON
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Checkout successful!");
          basket = {}; // Clear basket after successful checkout
          renderBasket();
          updateTotalPrice();
        } else {
          alert("An error occurred. Please try again.");
        }
      })
      .catch(error => {
        console.error("Error:", error);
        alert("An error occurred. Please try again.");
      });
    });
  });
  