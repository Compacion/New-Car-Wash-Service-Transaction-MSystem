<!-- Header include for CarWashS - include this file from pages in the CarWashS folder:
  <?php include __DIR__ . '/header.php'; ?> -->
<nav class="site-header" id="siteHeader">
  <div class="nav-inner">
    <div class="nav-left" style="display:flex;align-items:center;gap:12px">
      <button class="nav-toggle" id="navToggle" aria-expanded="false" aria-controls="mainNav">
        <span class="hamburger" aria-hidden="true"></span>
        <span class="sr-only">Toggle navigation</span>
      </button>

      <a href="/" class="site-title nav-brand" aria-label="Home">
        <span class="brand">The Crew Car Wash</span>
      </a>
    </div>

    < class="main-nav" id="mainNav" role="navigation" aria-label="Primary">
      <ul>
        <li><a href="homepage.php" title="Choose Services Here">Services</a></li>
        <li><a href="client.php" title="Add Client Here">Client</a></li>
        <li><a href="staff.php" title="Add Staff Here">Staff</a></li>
      </ul>
    </nav>

      <div class="user-block" style="position:relative">
        <button id="userBtn" class="user-toggle" aria-haspopup="true" aria-expanded="false" aria-controls="userMenu">
          <img src="images/avatar.png" alt="User avatar" class="user-avatar" />
        </button>
        <div id="userMenu" class="user-menu" role="menu" hidden>
          <a href="homepage.php" role="menuitem">Services</a>
          <a href="client.php" role="menuitem">Client</a>
          <a href="staff.php" role="menuitem">Staff</a>
        </div>
      </div>
    </div>
  </div>
</nav>

<script src="includes/nav.js" defer></script>
