/**
 * ACM Atlanta — Main JS
 */

document.addEventListener('DOMContentLoaded', function () {

    // ── Mobile Menu Toggle ──────────────────────────────
    const toggle = document.querySelector('.nav-toggle');
    const navMenu = document.querySelector('.site-nav ul');

    if (toggle && navMenu) {
        toggle.addEventListener('click', function () {
            const isOpen = navMenu.style.display === 'flex';
            navMenu.style.display = isOpen ? 'none' : 'flex';
            navMenu.style.flexDirection = 'column';
            navMenu.style.position = 'absolute';
            navMenu.style.top = '72px';
            navMenu.style.left = '0';
            navMenu.style.right = '0';
            navMenu.style.background = '#fff';
            navMenu.style.padding = '16px 24px';
            navMenu.style.boxShadow = '0 8px 24px rgba(0,40,85,0.12)';
            navMenu.style.zIndex = '100';
            toggle.setAttribute('aria-expanded', !isOpen);
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