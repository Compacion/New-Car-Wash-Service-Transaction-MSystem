<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clients - The Crew Car Wash</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navigation.php'; ?>

  <main class="main-content">
    <div class="dashboard-header">
      <div class="header-content">
        <h1>Clients</h1>
        <p class="header-subtitle">Manage all customer information</p>
      </div>
      <div class="header-actions">
        <button class="btn primary" onclick="document.querySelector('.client-form').scrollIntoView({ behavior: 'smooth' })">
          <span>➕</span> Add Client
        </button>
      </div>
    </div>

    <div class="container">
      <section class="panel form-card">
        <h2>New Client</h2>
        <p class="muted">Add client details for the car wash.</p>
        <form method="post" action="insert_datas.php" class="client-form" novalidate>
          <label>Client Name:</label>
          <input type="text" name="client_name" required>

          <label>Plate #:</label>
          <input type="text" name="plate_number" required>

          <label>Phone #:</label>
          <input type="number" name="phone_number" required>

          <label>Vehicle Type:</label>
          <input type="text" name="vehicle_type" required>

          <div class="form-actions">
            <button type="submit" name="submit" class="btn primary">Save</button>
            <button type="reset" class="btn ghost">Clear</button>
          </div>
        </form>
      </section>

      <section class="panel">
        <div style="margin-bottom: 1.5rem;">
          <h2>Client Records</h2>
          <input id="tableSearch" type="search" placeholder="Search clients..." style="width: 100%; padding: 0.6rem; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 0.5rem; color: #eaf6f8; margin-top: 0.5rem;">
        </div>

        <div class="stats-grid" id="clientsGrid">
          <?php
          include("db_connect.php");

          // Show Client as grid cards with latest booking info
          $sql = "SELECT c.*, b.booking_id, b.scheduled_at, s.name AS service_name, st.staff_name AS handled_by
                  FROM client c
                  LEFT JOIN (
                      SELECT * FROM bookings b1
                      WHERE b1.booking_id = (
                          SELECT booking_id FROM bookings b2 WHERE b2.client_id = b1.client_id ORDER BY b2.created_at DESC LIMIT 1
                      )
                  ) b ON b.client_id = c.client_id
                  LEFT JOIN services s ON s.service_id = b.service_id
                  LEFT JOIN staff st ON st.staff_id = b.staff_id
                  ORDER BY c.client_id DESC";
          $query = mysqli_query($conn, $sql);

          mysqli_report(MYSQLI_REPORT_OFF);
          if ($query && mysqli_num_rows($query) > 0) {
              while ($row = mysqli_fetch_assoc($query)) {
                  $id = htmlspecialchars($row['client_id']);
                  $name = htmlspecialchars($row['client_name']);
                  $plate = htmlspecialchars($row['plate_number']);
                  $phone = !empty($row['phone_number']) ? htmlspecialchars($row['phone_number']) : '-';
                  $vehicle = !empty($row['vehicle_type']) ? htmlspecialchars($row['vehicle_type']) : '-';
                  $service = isset($row['service_name']) && $row['service_name'] ? htmlspecialchars($row['service_name']) : '-';
                  $handled = isset($row['handled_by']) && $row['handled_by'] ? htmlspecialchars($row['handled_by']) : '-';
                  $scheduled = isset($row['scheduled_at']) && $row['scheduled_at'] ? htmlspecialchars($row['scheduled_at']) : '-';
                  
                  echo "<div class=\"stat-card client-card\" data-id=\"$id\" data-name=\"$name\">";
                  echo "<div class=\"stat-icon clients\">👤</div>";
                  echo "<div class=\"stat-content\">";
                  echo "<h3 style=\"margin-top:0\">$name</h3>";
                  echo "<p class=\"muted\" style=\"margin:0.3rem 0;font-size:0.85rem\"><strong>Plate:</strong> $plate</p>";
                  echo "<p class=\"muted\" style=\"margin:0.3rem 0;font-size:0.85rem\"><strong>Phone:</strong> $phone</p>";
                  echo "<p class=\"muted\" style=\"margin:0.3rem 0;font-size:0.85rem\"><strong>Vehicle:</strong> $vehicle</p>";
                  if ($service !== '-') {
                    echo "<p class=\"muted\" style=\"margin:0.3rem 0;font-size:0.85rem\"><strong>Service:</strong> $service</p>";
                    echo "<p class=\"muted\" style=\"margin:0.3rem 0;font-size:0.85rem\"><strong>Attendee:</strong> $handled</p>";
                  }
                  echo "</div>";
                  echo "</div>";
              }
          } else {
              echo "<p class=\"muted\">No client records found.</p>";
          }
          mysqli_close($conn);
          ?>
        </div>
      </section>
    </div>
  </main>

  <script src="carw.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const search = document.getElementById('tableSearch');
      const grid = document.getElementById('clientsGrid');
      
      if (search && grid) {
        search.addEventListener('input', function() {
          const query = this.value.toLowerCase();
          const cards = grid.querySelectorAll('.client-card');
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
