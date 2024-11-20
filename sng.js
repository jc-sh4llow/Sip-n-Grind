document.addEventListener('DOMContentLoaded', () => {
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const navbarItems = document.querySelector('.navbar-items');
    const logo = document.querySelector('.logo');
    const navbar = document.querySelector('.navbar');

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
                // Close the navbar and reset positions
                navbarItems.classList.remove('show');
                hamburgerBtn.classList.remove('hidden');
                logo.classList.remove('top');
            }
        }
    });

    // Collapse navbar on scroll
    window.addEventListener('scroll', () => {
        if (window.innerWidth <= 768 && navbarItems.classList.contains('show')) {
            // Close the navbar and reset positions
            navbarItems.classList.remove('show');
            hamburgerBtn.classList.remove('hidden');
            logo.classList.remove('top');
        }
    });
});
