// =============================================
// app.js — Global JavaScript
// =============================================
// Ye har page pe load hogi (layout me <script> hai)
// Isme woh JS likho jo HAR page pe chalni hai
// Page-specific JS @push('scripts') me likho
// =============================================

// =============================================
// 1. MOBILE MENU TOGGLE
// =============================================
// Kaam: Mobile pe hamburger menu open/close kare
//
// document.getElementById('mobile-menu-btn')
//   = HTML me id="mobile-menu-btn" wala element dhundho
//   (ye navbar me hai)
//
// .addEventListener('click', function(){...})
//   = Jab is element pe CLICK ho, toh ye function chalao
//
// document.getElementById('nav-links')
//   = Navigation links wala div
//
// classList.toggle('hidden')
//   = Agar hidden hai toh dikhao, agar dikh raha hai toh chhupao
//   (Tailwind me hidden = display:none)
// =============================================

var mobileMenuBtn = document.getElementById('mobile-menu-btn');
var navLinks = document.getElementById('nav-links');

if (mobileMenuBtn && navLinks) {
    mobileMenuBtn.addEventListener('click', function() {
        navLinks.classList.toggle('hidden');
    });
}

// =============================================
// 2. USER DROPDOWN TOGGLE
// =============================================
// Kaam: Navbar me user naam pe click karne se
//       dropdown menu open/close ho
//
// Logic same hai mobile menu jaisa
// Pehle dropdown-menu me 'hidden' class hai
// Click pe toggle karo
// =============================================

var dropdownBtn = document.getElementById('dropdown-btn');
var dropdownMenu = document.getElementById('dropdown-menu');

if (dropdownBtn && dropdownMenu) {
    dropdownBtn.addEventListener('click', function(event) {
        // event.stopPropagation() — Kya Hai?
        // Jab dropdown button pe click karo, toh
        // click event "bubble up" hota hai parent elements
        // tak. Agar hum ye nahi likhenge, toh document ka
        // click listener bhi chal jayega aur dropdown
        // turant band ho jayega (open hi nahi hoga).
        //
        // stopPropagation() = "Ye event yahi ruko,
        //   aage parent tak mat jao"
        event.stopPropagation();
        dropdownMenu.classList.toggle('hidden');
    });

    // Agar dropdown ke bahar click kare toh band karo
    document.addEventListener('click', function(event) {
        // Agar click dropdown menu ke ANDAR nahi hai
        if (!dropdownMenu.contains(event.target) && !dropdownBtn.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
}

// =============================================
// 3. AUTO-DISMISS ALERTS after 5 seconds
// =============================================
// Kaam: Success/Error alert 5 second baad
//       automatically gayab ho jaye
//
// setTimeout(function, 5000) = 5 second (5000ms)
//   baad ye function chalao
//
// querySelectorAll('[data-alert]') = HTML me
//   jahan bhi data-alert attribute hai wo elements
// =============================================

setTimeout(function() {
    var alerts = document.querySelectorAll('[data-alert]');
    alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.remove();
        }, 500);
    });
}, 5000);