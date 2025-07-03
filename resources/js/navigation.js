document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link, .mobile-nav-login');

    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('open');
    });

    document.addEventListener('click', function(event) {
        if (!mobileMenu.contains(event.target) &&
            !mobileMenuButton.contains(event.target) &&
            mobileMenu.classList.contains('open')) {
            mobileMenu.classList.remove('open');
        }
    });

    mobileLinks.forEach(link => {
        link.addEventListener('click', function() {
            mobileMenu.classList.remove('open');
        });
    });
});
