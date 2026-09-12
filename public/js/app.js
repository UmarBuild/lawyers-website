
(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    ready(function () {
        /* --------------------------------------------------------
           1) Mobile menu (slide-in from bottom + sequential links)
           -------------------------------------------------------- */
        var mobileMenuBtn   = document.getElementById('mobile-menu-btn');
        var mobileMenu      = document.getElementById('mobile-menu');
        var mobilePanel     = document.getElementById('mobile-menu-panel');
        var mobileBackdrop  = document.getElementById('mobile-backdrop');
        var iconOpen        = document.getElementById('menu-icon-open');
        var iconClose       = document.getElementById('menu-icon-close');

        var isMenuOpen = false;

        // The breakpoint at which desktop nav replaces the hamburger.
        // Matches Tailwind's `xl` (1280px) — closest default to 1200px.
        var DESKTOP_BREAKPOINT = 1280;

        function getMobileLinks() {
            return mobilePanel
                ? mobilePanel.querySelectorAll('.mobile-link')
                : [];
        }

        function resetLinkState() {
            var links = getMobileLinks();
            links.forEach(function (link) {
                link.style.opacity = '0';
                link.style.transform = 'translateY(16px)';
                link.style.transition = 'opacity 0.35s ease, transform 0.35s ease';
            });
        }

        function animateLinksIn() {
            var links = getMobileLinks();
            links.forEach(function (link, index) {
                // Stagger each link so they appear one after another
                setTimeout(function () {
                    link.style.opacity = '1';
                    link.style.transform = 'translateY(0)';
                }, 120 + index * 70);
            });
        }

        function openMobileMenu() {
            if (!mobileMenu || !mobilePanel) return;
            isMenuOpen = true;

            // Enable pointer events on overlay
            mobileMenu.classList.remove('pointer-events-none');
            mobileMenu.setAttribute('aria-hidden', 'false');

            // Swap icon
            if (iconOpen)  iconOpen.classList.add('hidden');
            if (iconClose) iconClose.classList.remove('hidden');

            // Lock body scroll
            document.body.style.overflow = 'hidden';

            // Make sure links are at their "hidden" starting state BEFORE animating
            resetLinkState();

            // Force reflow so transitions fire
            void mobilePanel.offsetWidth;

            // Animate backdrop + panel
            if (mobileBackdrop) mobileBackdrop.style.opacity = '1';
            mobilePanel.style.transform = 'translate(-50%, 0)';

            // Update button aria
            if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'true');

            // Stagger the links in
            animateLinksIn();
        }

        function closeMobileMenu() {
            if (!mobileMenu || !mobilePanel) return;
            isMenuOpen = false;

            // Fade backdrop + slide panel down
            if (mobileBackdrop) mobileBackdrop.style.opacity = '0';
            mobilePanel.style.transform = 'translate(-50%, 100%)';

            // Swap icon back
            if (iconOpen)  iconOpen.classList.remove('hidden');
            if (iconClose) iconClose.classList.add('hidden');

            // Restore scroll
            document.body.style.overflow = '';

            // Update button aria
            if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'false');

            // Disable pointer events after transition ends
            setTimeout(function () {
                mobileMenu.classList.add('pointer-events-none');
                mobileMenu.setAttribute('aria-hidden', 'true');
            }, 320);
        }

        if (mobileMenuBtn && mobileMenu && mobilePanel) {
            mobileMenuBtn.addEventListener('click', function () {
                if (isMenuOpen) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });

            // Close on backdrop click
            if (mobileBackdrop) {
                mobileBackdrop.addEventListener('click', closeMobileMenu);
            }

            // Close on any link with [data-mobile-close]
            document.querySelectorAll('[data-mobile-close]').forEach(function (el) {
                el.addEventListener('click', function () {
                    if (isMenuOpen) closeMobileMenu();
                });
            });

            // Close on Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && isMenuOpen) closeMobileMenu();
            });

            // Auto-close when resizing up to desktop
            window.addEventListener('resize', function () {
                if (window.innerWidth >= DESKTOP_BREAKPOINT && isMenuOpen) {
                    closeMobileMenu();
                }
            });

            // Initial state — links hidden until first open
            resetLinkState();
        }

        /* --------------------------------------------------------
           2) Desktop user dropdown
           -------------------------------------------------------- */
        var dropdownBtn  = document.getElementById('dropdown-btn');
        var dropdownMenu = document.getElementById('dropdown-menu');

        if (dropdownBtn && dropdownMenu) {
            dropdownBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });

            document.addEventListener('click', function (event) {
                if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });
        }

        /* --------------------------------------------------------
           3) Auto-dismiss flash alerts
           -------------------------------------------------------- */
        setTimeout(function () {
            var alerts = document.querySelectorAll('[data-alert]');
            alerts.forEach(function (alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function () {
                    alert.remove();
                }, 500);
            });
        }, 5000);
    });
})();