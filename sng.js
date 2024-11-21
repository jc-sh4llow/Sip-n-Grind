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
        searchBar.classList.toggle('show'); // Show/hide the search bar
        searchIconContainer.classList.toggle('active'); // Toggle the 'active' class for background and icon color

        // Optionally, focus on the search input if you want it to automatically start typing when the bar is expanded
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
});
