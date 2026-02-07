<!-- DEVELOPER QUICK REFERENCE -->

# 🚀 QUICK REFERENCE - The Crew Car Wash Enhanced UI

## 📋 File Locations & Purposes

| File | Purpose | Status |
|------|---------|--------|
| `index.php` | Entry point (redirects to dashboard) | ✅ NEW |
| `includes/dashboard.php` | Main dashboard with statistics | ✅ NEW |
| `includes/navigation.php` | Global navigation component | ✅ NEW |
| `includes/homepage.php` | Services management | ✅ ENHANCED |
| `includes/client.php` | Client management | ✅ ENHANCED |
| `includes/staff.php` | Staff management | ✅ ENHANCED |
| `includes/book_service.php` | Booking system | ✅ ENHANCED |
| `includes/payment.php` | Payment processing | ✅ ENHANCED |
| `includes/styles.css` | All styling | ✅ UPDATED |
| `includes/carw.js` | JavaScript utilities | ✅ EXISTING |
| `includes/db_connect.php` | Database connection | ✅ EXISTING |

---

## 🎨 CSS CLASSES REFERENCE

### Layout & Containers
```html
<main class="main-content">           <!-- Main content wrapper -->
<div class="dashboard-header">        <!-- Page header with title -->
<div class="container">               <!-- Content container -->
```

### Typography & Text
```html
<h1>Title</h1>                        <!-- Page title (2.5rem) -->
<p class="header-subtitle">Sub</p>    <!-- Page subtitle (1rem, muted) -->
<p class="muted">Muted text</p>      <!-- Secondary text -->
```

### Buttons
```html
<button class="btn primary">Action</button>     <!-- Main CTA -->
<button class="btn secondary">Alt</button>     <!-- Alternative action -->
<button class="btn ghost">Other</button>       <!-- Tertiary action -->
```

### Cards & Grids
```html
<div class="stats-grid">              <!-- 4-column responsive grid -->
  <div class="stat-card">             <!-- Individual stat card -->
    <div class="stat-icon">📊</div>
    <div class="stat-content">
      <h3>Title</h3>
      <p class="stat-value">42</p>
      <a class="stat-link">View →</a>
    </div>
  </div>
</div>
```

### Quick Actions
```html
<div class="quick-actions">           <!-- Quick actions grid -->
  <a class="quick-action-card">       <!-- Individual action -->
    <span class="action-icon">📅</span>
    <span class="action-title">Title</span>
    <span class="action-desc">Description</span>
  </a>
</div>
```

### Activity Feed
```html
<div class="recent-activity">         <!-- Activity container -->
  <div class="activity-list">         <!-- Activity list -->
    <div class="activity-item">       <!-- Individual activity -->
      <div class="activity-avatar">📅</div>
      <div class="activity-details">
        <h4>Title</h4>
        <p>Description</p>
        <span class="activity-time">Time</span>
      </div>
      <div class="activity-status">
        <span class="badge badge-success">Status</span>
      </div>
    </div>
  </div>
</div>
```

### Tables
```html
<div class="table-header">            <!-- Table header with search -->
  <h2>Title</h2>
  <input class="search-input">
</div>
<div class="table-wrap">              <!-- Scrollable table wrapper -->
  <table class="styled-table">        <!-- Main table -->
    <thead><tr><th>Header</th></tr></thead>
    <tbody><tr><td>Data</td></tr></tbody>
  </table>
</div>
```

### Forms
```html
<form class="client-form">            <!-- Form wrapper -->
  <label>Field Name:</label>
  <input type="text" required>
  <label>Select Field:</label>
  <select required>
    <option>Option 1</option>
  </select>
  <div class="form-actions">          <!-- Button group -->
    <button class="btn primary" type="submit">Save</button>
    <button class="btn ghost" type="reset">Clear</button>
  </div>
</form>
```

### Navigation
```html
<header class="site-header">
  <div class="header-container">
    <div class="logo-section">
      <button class="nav-toggle"></button>  <!-- Mobile menu toggle -->
      <a class="site-logo">                  <!-- Logo/brand -->
        <span class="logo-icon">🚗</span>
        <span class="logo-text">
          <span class="brand-name">The Crew</span>
          <span class="brand-subtitle">Car Wash</span>
        </span>
      </a>
    </div>
    <nav class="main-nav">
      <ul class="nav-list">
        <li class="nav-item">
          <a href="page.php" class="nav-link">  <!-- Individual nav item -->
            <span class="nav-icon">📊</span>
            <span class="nav-label">Dashboard</span>
          </a>
        </li>
      </ul>
    </nav>
    <div class="nav-right">
      <div class="user-menu-container">
        <button class="user-menu-toggle" id="userMenuToggle">
          <span class="user-avatar">👤</span>
        </button>
        <div class="user-dropdown" id="userDropdown">
          <a class="dropdown-item">Settings</a>
          <hr class="dropdown-divider">
          <a class="dropdown-item logout">Logout</a>
        </div>
      </div>
    </div>
  </div>
</header>
```

### Badges & Status
```html
<span class="badge badge-success">Success</span>   <!-- Green -->
<span class="badge badge-warning">Warning</span>   <!-- Yellow -->
<span class="badge badge-danger">Danger</span>     <!-- Red -->
```

---

## 🎯 CSS VARIABLES

```css
/* Core Colors */
--bg: #0f1416;                    /* Main background */
--bg-light: #1a1d1f;             /* Light background */
--panel: #121416;                /* Panel background */
--muted: #9fb3b6;                /* Muted text */

/* Brand Colors */
--accent: #3399cc;               /* Primary blue */
--accent-2: #7ad0e6;             /* Secondary cyan */
--accent-3: #ff6b35;             /* Accent orange */

/* Status Colors */
--success: #22c55e;              /* Success green */
--warning: #f59e0b;              /* Warning yellow */
--danger: #ef4444;               /* Error red */

/* UI Elements */
--card-bg: rgba(255,255,255,0.03);  /* Card background */
--border: rgba(255,255,255,0.08);   /* Border color */
```

---

## 📝 TEMPLATE - Add New Page

```php
<?php
include 'db_connect.php';
// Your PHP code here
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page Title - The Crew Car Wash</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navigation.php'; ?>

  <main class="main-content">
    <!-- Page Header -->
    <div class="dashboard-header">
      <div class="header-content">
        <h1>Page Title</h1>
        <p class="header-subtitle">Subtitle or description</p>
      </div>
    </div>

    <!-- Your Content Here -->
    <div class="container">
      <!-- Forms, Tables, etc. -->
    </div>
  </main>

  <script src="carw.js"></script>
</body>
</html>
```

---

## 🎨 RESPONSIVE BREAKPOINTS

```css
/* Desktop First */
@media (max-width: 1024px) { /* Tablet */ }
@media (max-width: 768px)  { /* Mobile */ }
@media (max-width: 480px)  { /* Small Mobile */ }
```

---

## 🔧 COMMON CUSTOMIZATIONS

### Change Primary Color
```css
:root {
  --accent: #newcolor;  /* Change this */
}
```

### Hide Element on Mobile
```css
@media (max-width: 768px) {
  .element { display: none; }
}
```

### Adjust Grid Columns
```css
.stats-grid {
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}
```

### Change Button Style
```css
.btn.primary {
  background: linear-gradient(90deg, var(--accent), var(--accent-2));
}
```

---

## ✅ INCLUDE CHECKLIST

When creating new pages, ensure:
- ✅ Include `navigation.php` in body
- ✅ Wrap content in `<main class="main-content">`
- ✅ Add viewport meta tag for mobile
- ✅ Use `<meta name="viewport" content="width=device-width, initial-scale=1.0">`
- ✅ Include `styles.css` link
- ✅ Use consistent button styles
- ✅ Make forms responsive
- ✅ Test on mobile

---

## 🚀 QUICK SNIPPETS

### Add a Stat Card to Dashboard
```php
<div class="stat-card">
  <div class="stat-icon services">🆕</div>
  <div class="stat-content">
    <h3>New Metric</h3>
    <p class="stat-value"><?php echo $count; ?></p>
    <a href="page.php" class="stat-link">View all →</a>
  </div>
</div>
```

### Add Navigation Item
```html
<li class="nav-item">
  <a href="page.php" class="nav-link">
    <span class="nav-icon">🆕</span>
    <span class="nav-label">New Page</span>
  </a>
</li>
```

### Add Quick Action
```html
<a href="page.php" class="quick-action-card">
  <span class="action-icon">📅</span>
  <span class="action-title">Title</span>
  <span class="action-desc">Description</span>
</a>
```

### Search Table
```javascript
const search = document.getElementById('tableSearch');
const table = document.getElementById('myTable');

search.addEventListener('input', function() {
  const query = this.value.toLowerCase();
  for (let row of table.tBodies[0].rows) {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(query) ? '' : 'none';
  }
});
```

---

## 📊 COLOR PALETTE

| Color | Hex | Use |
|-------|-----|-----|
| Primary | #3399cc | Links, buttons, borders |
| Secondary | #7ad0e6 | Highlights, accents |
| Accent | #ff6b35 | Important elements |
| Success | #22c55e | Success states |
| Warning | #f59e0b | Warnings |
| Danger | #ef4444 | Errors |

---

## 🎯 Z-Index Hierarchy

```css
--z-header: 1000      /* Sticky header */
--z-nav-dropdown: 1001  /* Dropdowns over header */
--z-modal: 1002       /* Modals (future) */
```

---

**Last Updated**: January 2026
**Version**: 2.0
**Ready for**: Production
