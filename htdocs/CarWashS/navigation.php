<?php
// Enhanced Navigation Component
// Include this in all pages: <?php include 'navigation.php'; ?>
?>
<header class="site-header" role="banner">
    <div class="header-container">
        <!-- Logo & Brand -->
        <div class="logo-section">
            <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="mainNav" aria-label="Toggle navigation">
                <span class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
            <a href="dashboard.php" class="site-logo">
                <span class="logo-icon">🚗</span>
                <span class="logo-text">
                    <span class="brand-name">The Crew</span>
                    <span class="brand-subtitle">Car Wash</span>
                </span>
            </a>
        </div>

        <!-- Main Navigation -->
        <nav id="mainNav" class="main-nav" role="navigation" aria-label="Main">
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="dashboard.php" class="nav-link" title="Dashboard">
                        <span class="nav-icon">📊</span>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="homepage.php" class="nav-link" title="Services">
                        <span class="nav-icon">🛁</span>
                        <span class="nav-label">Services</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="client.php" class="nav-link" title="Clients">
                        <span class="nav-icon">👥</span>
                        <span class="nav-label">Clients</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="staff.php" class="nav-link" title="Attendees">
                        <span class="nav-icon">👥</span>
                        <span class="nav-label">Attendees</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="book_service.php" class="nav-link" title="Bookings">
                        <span class="nav-icon">📅</span>
                        <span class="nav-label">Bookings</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="payment.php" class="nav-link" title="Payments">
                        <span class="nav-icon">💰</span>
                        <span class="nav-label">Payments</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Right Section -->
        <div class="nav-right">
            <div class="search-container">
                <input type="search" class="search-input" placeholder="Search..." aria-label="Search">
                <span class="search-icon">🔍</span>
            </div>

            <!-- User Menu -->
            <div class="user-menu-container">
                <button class="user-menu-toggle" id="userMenuToggle" aria-expanded="false" aria-haspopup="true" aria-controls="userDropdown">
                    <span class="user-avatar">👤</span>
                </button>
                <div id="userDropdown" class="user-dropdown" role="menu" hidden>
                    <a href="#" role="menuitem" class="dropdown-item">
                        <span class="icon">⚙️</span> Settings
                    </a>
                    <a href="#" role="menuitem" class="dropdown-item">
                        <span class="icon">📋</span> Profile
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" role="menuitem" class="dropdown-item logout">
                        <span class="icon">🚪</span> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Navigation Toggle
    const navToggle = document.getElementById('navToggle');
    const mainNav = document.getElementById('mainNav');
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userDropdown = document.getElementById('userDropdown');

    if (navToggle && mainNav) {
        navToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            document.documentElement.classList.toggle('nav-open');
        });

        // Close menu when clicking a link
        mainNav.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                navToggle.setAttribute('aria-expanded', 'false');
                document.documentElement.classList.remove('nav-open');
            });
        });
    }

    // User Menu Dropdown
    if (userMenuToggle && userDropdown) {
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);
            userDropdown.hidden = isExpanded;
        });

        // Close when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.user-menu-container')) {
                userMenuToggle.setAttribute('aria-expanded', 'false');
                userDropdown.hidden = true;
            }
        });
    }

    // Active nav indicator
    const currentPage = window.location.pathname.split('/').pop();
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.classList.add('active');
        }
    });
});
</script>
