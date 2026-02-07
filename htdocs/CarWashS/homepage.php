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

      <section class="panel table-card">
        <div class="table-header">
          <h2>Service Records</h2>
          <div class="table-actions">
            <input id="tableSearch" type="search" placeholder="Search services...">
          </div>
        </div>
        <div class="table-wrap">
          <?php
          $sql = "SELECT service_id, name, price, description FROM services ORDER BY service_id DESC";
          $res = mysqli_query($conn, $sql);
          if ($res && mysqli_num_rows($res) > 0) {
            echo "<table class=\"styled-table\"><thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Description</th></tr></thead><tbody>";
            while ($row = mysqli_fetch_assoc($res)) {
              $id = htmlspecialchars($row['service_id']);
              $name = htmlspecialchars($row['name']);
              $price = htmlspecialchars($row['price']);
              $desc = htmlspecialchars($row['description']);
              echo "<tr><td>$id</td><td>$name</td><td>\$$price</td><td>$desc</td></tr>";
            }
            echo "</tbody></table>";
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
      const tables = document.querySelectorAll('table');
      
      if (search && tables.length > 0) {
        search.addEventListener('input', function() {
          const query = this.value.toLowerCase();
          tables.forEach(table => {
            if (table.tBodies[0]) {
              for (let row of table.tBodies[0].rows) {
                const text = (row.textContent || row.innerText).toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
              }
            }
          });
        });
      }
    });
  </script>
</body>
</html>
