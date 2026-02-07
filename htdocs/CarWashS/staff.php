<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Staff - The Crew Car Wash</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navigation.php'; ?>

  <main class="main-content">
    <div class="dashboard-header">
      <div class="header-content">
        <h1>Attendee Management</h1>
        <p class="header-subtitle">Manage attendees and their schedules</p>
      </div>
      <div class="header-actions">
        <button class="btn primary" onclick="document.querySelector('.staff-form').scrollIntoView({ behavior: 'smooth' })">
          <span>➕</span> Add Attendee
        </button>
      </div>
    </div>

    <div class="container">
      <section class="panel form-card">
        <h2>New Attendee</h2>
        <p class="muted">Add a new attendee to the system.</p>
        <form method="post" action="insert_staff.php" class="staff-form">
          <label>Attendee Name</label>
          <input type="text" name="staff_name" required>

          <label>Role</label>
          <input type="text" name="role" placeholder="e.g., washer, cashier">

          <div class="form-actions">
            <button class="btn primary" type="submit">Add</button>
            <button class="btn ghost" type="reset">Clear</button>
          </div>
        </form>
      </section>

      <section class="panel table-card">
        <div class="table-header">
          <h2>Attendee List</h2>
          <div class="table-actions">
            <input id="tableSearch" type="search" placeholder="Search attendees...">
          </div>
        </div>
        <div class="table-wrap">
          <?php
          include('db_connect.php');
          // Show staff with booking count and last handled booking time
          $sql = "SELECT st.staff_id, st.staff_name, st.role, st.phone,
                         COUNT(b.booking_id) AS bookings_handled,
                         MAX(b.scheduled_at) AS last_handled
                  FROM staff st
                  LEFT JOIN bookings b ON b.staff_id = st.staff_id
                  GROUP BY st.staff_id
                  ORDER BY st.staff_id DESC";
          $res = mysqli_query($conn, $sql);
          if ($res && mysqli_num_rows($res) > 0) {
            echo "<table id=\"staffTable\" class=\"styled-table\">";
            echo "<thead><tr><th>ID</th><th>Name</th><th>Role</th><th>Phone</th><th>Bookings</th><th>Last Handled</th></tr></thead><tbody>";
            while ($r = mysqli_fetch_assoc($res)) {
              $id = htmlspecialchars($r['staff_id']);
              $name = htmlspecialchars($r['staff_name']);
              $role = !empty($r['role']) ? htmlspecialchars($r['role']) : '-';
              $phone = !empty($r['phone']) ? htmlspecialchars($r['phone']) : '-';
              $count = intval($r['bookings_handled']);
              $last = $r['last_handled'] ? htmlspecialchars($r['last_handled']) : '-';
              echo "<tr><td>$id</td><td>$name</td><td>$role</td><td>$phone</td><td>$count</td><td>$last</td></tr>";
            }
            echo "</tbody></table>";
          } else {
            echo "<p class=\"muted\">No staff records yet.</p>";
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
      const table = document.getElementById('staffTable');
      
      if (search && table) {
        search.addEventListener('input', function() {
          const query = this.value.toLowerCase();
          for (let row of table.tBodies[0].rows) {
            const text = (row.textContent || row.innerText).toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
          }
        });
      }
    });
  </script>
</body>
</html>
