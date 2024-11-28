document.addEventListener('DOMContentLoaded', () => {
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const navbarItems = document.querySelector('.navbar-items');
    const logo = document.querySelector('.logo');
    const navbar = document.querySelector('.navbar');
    const searchIconContainer = document.querySelector('.search-icon-container');
    const searchBar = document.querySelector('.search-bar');
    

    // Toggle the navbar visibility when the hamburger button is clicked
    hamburgerBtn.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent the click from propagating to document (which would collapse the menu)
        navbarItems.classList.toggle('show');

        // Toggle visibility of hamburger button and position of logo
        if (navbarItems.classList.contains('show')) {
            hamburgerBtn.classList.add('hidden'); // Hide hamburger button
            logo.classList.add('top'); // Move logo to top
        } else {
            hamburgerBtn.classList.remove('hidden'); // Show hamburger button
            logo.classList.remove('top'); // Reset logo position
        }
    });

    // Collapse navbar and reset the logo when clicking outside
    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 768) {
            const clickedInsideNavbar = navbar.contains(event.target) || hamburgerBtn.contains(event.target);
            if (!clickedInsideNavbar && navbarItems.classList.contains('show')) {
                // Add the 'hide' class for animation before removing 'show'
                navbarItems.classList.add('hide');
                setTimeout(() => {
                    navbarItems.classList.remove('show');
                    navbarItems.classList.remove('hide');
                }, 300); // Duration matches the transition time
                hamburgerBtn.classList.remove('hidden');
                logo.classList.remove('top');
            }
        }
    });

    // Collapse navbar on scroll
    window.addEventListener('scroll', () => {
        if (window.innerWidth <= 768 && navbarItems.classList.contains('show')) {
            // Add 'hide' class before removing 'show' for smooth closing
            navbarItems.classList.add('hide');
            setTimeout(() => {
                navbarItems.classList.remove('show');
                navbarItems.classList.remove('hide');
            }, 300); // Duration matches the transition time
            hamburgerBtn.classList.remove('hidden');
            logo.classList.remove('top');
        }
    });

    searchIconContainer.addEventListener('click', () => {
        searchBar.classList.toggle('show');
        searchIconContainer.classList.toggle('active');
        if (searchBar.classList.contains('show')) {
            searchBar.querySelector('input').focus();
        }
    });

    function toggleNavbar() {
        const navbar = document.querySelector('.navbar');
        const logo = document.querySelector('.navbar .logo');
        const hamburger = document.querySelector('.navbar .hamburger');
      
        navbar.classList.toggle('expanded');
        navbar.classList.toggle('collapsed');
        if (navbar.classList.contains('expanded')) {
          logo.classList.add('slide-in');
          logo.classList.remove('slide-out');
          hamburger.classList.add('slide-in');
          hamburger.classList.remove('slide-out');
        } else {
          logo.classList.add('slide-out');
          logo.classList.remove('slide-in');
          hamburger.classList.add('slide-out');
          hamburger.classList.remove('slide-in');
          navbarItems.classList.add('collapsed');
        }
      }
      

    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 768) {
            // Check if the click is inside the search bar or the search icon container
            const clickedInsideSearchBar = searchBar.contains(event.target) || searchIconContainer.contains(event.target);
            if (!clickedInsideSearchBar && searchBar.classList.contains('show')) {
                // Add the 'hide' class for animation before removing 'show'
                searchBar.classList.add('hide');
                setTimeout(() => {
                    searchBar.classList.remove('show');
                    searchBar.classList.remove('hide');
                }, 300); // Duration matches the transition time
                searchIconContainer.classList.remove('active');
            }
        }
    });

    const aboutDropdown = document.getElementById('about-dropdown')
    const aboutDropdownMenu = document.getElementById('about-dropdown-menu')
    const orderDropdown = document.getElementById('order-dropdown')
    const orderDropdownMenu = document.getElementById('order-dropdown-menu')
    const locationDropdown = document.getElementById('location-dropdown')
    const locationDropdownMenu = document.getElementById('location-dropdown-menu')
    const socialDropdown = document.getElementById('social-dropdown')
    const socialDropdownMenu = document.getElementById('social-dropdown-menu')
    const toggleDropdown = (dropdown, dropdownMenu) =>{
        dropdownMenu.classList.toggle('active');

        if(dropdownMenu.classList.contains('active')){
            dropdownMenu.scrollIntoView({behavior: "smooth", block: "start"})
        }
    };

    aboutDropdown.addEventListener("click", () => toggleDropdown(aboutDropdown, aboutDropdownMenu));
    orderDropdown.addEventListener("click", () => toggleDropdown(orderDropdown, orderDropdownMenu));
    locationDropdown.addEventListener("click", () => toggleDropdown(locationDropdown, locationDropdownMenu));
    socialDropdown.addEventListener("click", () => toggleDropdown(socialDropdown, socialDropdownMenu));

    document.addEventListener("click", (event) => {
        if (!aboutDropdown.contains(event.target) && !aboutDropdownMenu.contains(event.target)) {
            aboutDropdownMenu.classList.remove('active');
        }
        if (!orderDropdown.contains(event.target) && !orderDropdownMenu.contains(event.target)) {
            orderDropdownMenu.classList.remove('active');
        }
        if (!locationDropdown.contains(event.target) && !locationDropdownMenu.contains(event.target)) {
            locationDropdownMenu.classList.remove('active');
        }
        if (!socialDropdown.contains(event.target) && !socialDropdownMenu.contains(event.target)) {
            socialDropdownMenu.classList.remove('active');
        }
    });

    window.addEventListener('scroll', () => {
        // Check if dropdowns are scrolled out of the viewport
        const dropdowns = [aboutDropdownMenu, orderDropdownMenu, locationDropdownMenu, socialDropdownMenu];
        
        dropdowns.forEach((dropdownMenu) => {
            const rect = dropdownMenu.getBoundingClientRect();
            // Check if dropdown is fully out of the viewport (above or below the window)
            if (rect.bottom < 0 || rect.top > window.innerHeight) {
                dropdownMenu.classList.remove('active');
            }
        });
    });
    
    const addToCartButtons = document.querySelectorAll(".add-to-cart");
    const basketItemsContainer = document.getElementById("basket-items");
    const totalPriceElement = document.getElementById("total-price");

    
    console.log(basketItemsContainer);
    let basket = {};

    function updateTotalPrice() {
        let totalPrice = Object.values(basket).reduce(
          (sum, item) => sum + item.quantity * item.price,
          0
        );
        totalPriceElement.textContent = totalPrice.toFixed(2);
    }
    
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

            const imgContainer = document.createElement("div");
            imgContainer.className = "img-container";
    
            const img = document.createElement("img");
            img.src = imgSrc;
            img.alt = name;
            
            imgContainer.appendChild(img);
    
            const details = document.createElement("div");
            details.className = "basket-item-details";
    
            const itemName = document.createElement("h4");
            itemName.textContent = name;
    
            const itemSize = document.createElement("p");
            itemSize.textContent = `Size: ${size}`;
    
            const itemPrice = document.createElement("p");
            itemPrice.textContent = `₱${price} x ${quantity}`;
    
            details.appendChild(itemName);
            details.appendChild(itemSize);
            details.appendChild(itemPrice);
    
            const removeButton = document.createElement("button");
            removeButton.textContent = "Remove";
            removeButton.addEventListener("click", function () {
                basket[key].quantity -= 1;
                if (basket[key].quantity <= 0) {
                    delete basket[key];
                }
                renderBasket();
                updateTotalPrice();
            });
    
            basketItem.appendChild(img);
            basketItem.appendChild(details);
            basketItem.appendChild(removeButton);
            basketItemsContainer.appendChild(basketItem);
        }
    }
    

    addToCartButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const itemId = button.getAttribute("data-id");
            const name = button.getAttribute("data-name");
            const price = parseFloat(button.getAttribute("data-price"));
            const size = button.getAttribute("data-size");
            const imgSrc = button.closest('.menu-item').querySelector("img").src;
    
            const itemKey = `${itemId}-${size}`;
    
            if (basket[itemKey]) {
                basket[itemKey].quantity += 1;
            } else {
                basket[itemKey] = { name, price, quantity: 1, imgSrc, size };
            }
    
            renderBasket();
            updateTotalPrice();
        });
    });
    

    const checkoutButton = document.getElementById("checkout-button");
    checkoutButton.addEventListener("click", function () {
        if (Object.keys(basket).length === 0) {
          alert("Your basket is empty!");
          return;
        }
        
        const cartData = JSON.stringify(basket);
        
        fetch('save_cart_to_session.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: cartData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                
                window.location.href = 'checkout.php';
            } else {
                alert('Failed to save cart data.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
        
    });


    window.addEventListener('scroll', function() {
        const cartContainer = document.querySelector('.cart-container');
        const cartArea = document.querySelector('.cart-area');
        
        const scrollTop = window.scrollY;
        const cartBottom = cartContainer.offsetTop + cartContainer.offsetHeight;
    
        if (cartBottom >= window.innerHeight) {
            cartContainer.classList.add('sticky-bottom');
        } else {
            cartContainer.classList.remove('sticky-bottom');
        }
    });
    
    const maxVisibleItems = 6;
const itemHeight = 100;

function adjustCartHeight() {
    const maxHeight = maxVisibleItems * itemHeight;
    basketItemsContainer.style.maxHeight = `${maxHeight}px`;
    basketItemsContainer.style.overflowY = "auto";
}

adjustCartHeight();



});
