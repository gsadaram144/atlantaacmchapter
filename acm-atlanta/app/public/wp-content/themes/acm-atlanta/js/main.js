/**
 * ACM Atlanta — Main JS
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile Menu Toggle ──────────────────────────────
    const toggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.site-nav ul');

    if (toggle && navMenu) {
        const nav = toggle.closest('.site-header').querySelector('.site-nav');

        toggle.addEventListener('click', function () {
            const isOpen = nav.classList.toggle('is-open');
            toggle.classList.toggle('is-open', isOpen);
            toggle.setAttribute('aria-expanded', isOpen);
        });

        // Close the menu after a link is tapped
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function () {
                nav.classList.remove('is-open');
                toggle.classList.remove('is-open');
                toggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // ── Smooth Scroll for Anchor Links ──────────────────
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

});