<?php
// Services records page
include 'db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Services - The Crew Car Wash</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navigation.php'; ?>

  <main class="main-content">
    <div class="dashboard-header">
      <div class="header-content">
        <h1>Services</h1>
        <p class="header-subtitle">Manage all available car wash services</p>
      </div>
      <div class="header-actions">
        <button class="btn primary" onclick="document.querySelector('.service-form').scrollIntoView({ behavior: 'smooth' })">
          <span>➕</span> Add Service
        </button>
      </div>
    </div>

    <div class="container">
      <section class="panel form-card">
        <h2>New Service</h2>
        <p class="muted">Add a new car wash service to the system.</p>
        <form method="post" action="insert_service.php" class="service-form" novalidate>
          <label>Service Name:</label>
          <input type="text" name="name" required>

          <label>Price:</label>
          <input type="number" name="price" step="0.01" min="0" required>

          <label>Description:</label>
          <textarea name="description" placeholder="Enter service description"></textarea>

          <div class="form-actions">
            <button type="submit" name="submit" class="btn primary">Add Service</button>
            <button type="reset" class="btn ghost">Clear</button>
          </div>
        </form>
      </section>

      <section class="panel">
        <h2>Available Services</h2>
        <div style="margin-bottom: 1.5rem;">
          <input id="tableSearch" type="search" placeholder="Search services..." style="width: 100%; padding: 0.6rem; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 0.5rem; color: #eaf6f8;">
        </div>
        <div class="stats-grid" id="servicesGrid">
          <?php
          $sql = "SELECT service_id, name, price, description FROM services ORDER BY service_id DESC";
          $res = mysqli_query($conn, $sql);
          if ($res && mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
              $id = htmlspecialchars($row['service_id']);
              $name = htmlspecialchars($row['name']);
              $price = htmlspecialchars($row['price']);
              $desc = htmlspecialchars($row['description']);
              echo "<div class=\"stat-card service-card\" data-id=\"$id\" data-name=\"$name\">";
              echo "<div class=\"stat-icon services\">🛁</div>";
              echo "<div class=\"stat-content\">";
              echo "<h3 style=\"margin-top:0\">$name</h3>";
              echo "<p class=\"stat-value\" style=\"font-size:1.75rem;margin:0.5rem 0\">\$$price</p>";
              echo "<p class=\"muted\" style=\"font-size:0.85rem;margin:0.5rem 0;line-height:1.4\">$desc</p>";
              echo "</div>";
              echo "</div>";
            }
          } else {
            echo "<p class=\"muted\">No services found. <a href=\"#\">Create one</a></p>";
          }
          ?>
        </div>
      </section>
    </div>
  </main>

  <script src="carw.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const search = document.getElementById('tableSearch');
      const grid = document.getElementById('servicesGrid');
      
      if (search && grid) {
        search.addEventListener('input', function() {
          const query = this.value.toLowerCase();
          const cards = grid.querySelectorAll('.service-card');
          cards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            card.style.display = name.includes(query) ? '' : 'none';
          });
        });
      }
    });
  </script>
</body>
</html>
