<?php
include('db_connect.php');

$client_id = isset($_GET['client_id']) ? intval($_GET['client_id']) : 0;
if ($client_id <= 0) {
    // Show client selection
    $clients = mysqli_query($conn, "SELECT * FROM client ORDER BY client_name");
    $client = null;
} else {
    $client = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM client WHERE client_id = " . $client_id));
    if (!$client) { echo "Client not found."; exit; }
}

$services = mysqli_query($conn, "SELECT * FROM services ORDER BY name");
$staff = mysqli_query($conn, "SELECT * FROM staff ORDER BY staff_name");

// user-facing error messages (from redirects)
$errorMsg = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'missing') $errorMsg = 'Please select a service and schedule date/time.';
    elseif ($_GET['error'] === 'sql') $errorMsg = 'Failed to create booking. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Service - The Crew Car Wash</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navigation.php'; ?>

  <main class="main-content">
    <div class="dashboard-header">
      <div class="header-content">
        <h1>Book Service</h1>
        <p class="header-subtitle">Schedule a car wash service for your clients</p>
      </div>
    </div>

    <div class="container">
      <section class="panel form-card">
        <?php if (!empty($errorMsg)): ?>
          <div class="notice error" style="margin-bottom:1rem; padding:0.8rem; border-left:4px solid #d9534f; background: rgba(169,46,46,0.04);">
            <?php echo htmlspecialchars($errorMsg); ?>
          </div>
        <?php endif; ?>

        <?php if ($client): ?>
          <h2>New Booking</h2>
          <div style="background: rgba(122, 208, 230, 0.06); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border-left: 4px solid var(--accent-2);">
            <p style="margin: 0;"><strong>Client:</strong> <?php echo htmlspecialchars($client['client_name']); ?></p>
            <?php if (!empty($client['plate_number']) || !empty($client['vehicle_type'])): ?>
              <p style="margin: 0.5rem 0 0 0;"><strong>Vehicle:</strong>
                <?php if (!empty($client['plate_number'])) echo htmlspecialchars($client['plate_number']); ?>
                <?php if (!empty($client['vehicle_type'])) echo ' (' . htmlspecialchars($client['vehicle_type']) . ')'; ?>
              </p>
            <?php endif; ?>
          </div>

          <form method="post" action="insert_booking.php">
            <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
            
            <label>Service</label>
            <select name="service_id" required style="width: 100%; padding: 0.6rem; background: rgba(255, 255, 255, 0.05); border: 1px solid var(--border); border-radius: 0.5rem; color: #eaf6f8; margin-top: 0.5rem;">
              <option value="">-- Select Service --</option>
              <?php 
              mysqli_data_seek($services, 0);
              while ($s = mysqli_fetch_assoc($services)) { 
                echo '<option value="'. $s['service_id'] .'">'.htmlspecialchars($s['name']).' — $'.number_format($s['price'],2).'</option>'; 
              } 
              ?>
            </select>

            <label>Assign Attendee (Optional)</label>
            <select id="attendeeSelect" name="staff_id" style="width: 100%; padding: 0.6rem; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 0.5rem; color: #eaf6f8; margin-top: 0.5rem;">
              <option value="">-- Any Available Attendee --</option>
              <?php 
              mysqli_data_seek($staff, 0);
              while ($st = mysqli_fetch_assoc($staff)) { 
                $roleSafe = htmlspecialchars($st['role']);
                echo '<option value="'.$st['staff_id'].'" data-role="'. $roleSafe .'">'.htmlspecialchars($st['staff_name']).' ('. $roleSafe .')</option>'; 
              } 
              ?>
            </select>

            <div id="attendeeRoleInfo" style="margin-top:0.6rem;color:var(--muted);display:none">Role: <span id="attRole" style="font-weight:700;color:var(--accent-2)"></span></div>

            <label>Schedule Date & Time</label>
            <input type="datetime-local" name="scheduled_at" required style="margin-top: 0.5rem;">

            <div class="form-actions">
              <button id="bookBtn" class="btn primary" type="button">Book Service</button>
              <a href="client.php" class="btn ghost">Cancel</a>
            </div>
          
          <!-- Confirmation modal -->
          <div id="confirmModal" class="panel" style="position:fixed;left:50%;top:50%;transform:translate(-50%,-50%);max-width:480px;display:none;z-index:2000;">
            <h3>Confirm Booking</h3>
            <div id="confirmBody" style="color:var(--muted);margin-bottom:12px"></div>
            <div style="display:flex;gap:10px;justify-content:flex-end">
              <button id="confirmYes" class="btn primary">Confirm</button>
              <button id="confirmNo" class="btn ghost">Cancel</button>
            </div>
          </div>
          <div id="modalBackdrop" style="position:fixed;inset:0;background:rgba(0,0,0,0.6);display:none;z-index:1999"></div>
          </form>
        <?php else: ?>
          <h2>Select Client</h2>
          <p class="muted">Choose a client to book a service</p>
          <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem;">
            <?php 
            if ($clients && mysqli_num_rows($clients) > 0) {
              while ($c = mysqli_fetch_assoc($clients)) { 
                echo '<a href="?client_id=' . intval($c['client_id']) . '" class="quick-action-card" style="text-decoration: none; display:block;">';
                echo '<div style="text-align: left;">';
                echo '<strong>' . htmlspecialchars($c['client_name']) . '</strong><br>';
                if (!empty($c['plate_number'])) echo '<small style="color: var(--muted);">' . htmlspecialchars($c['plate_number']) . '</small><br>';
                if (!empty($c['vehicle_type'])) echo '<small style="color: var(--muted);">' . htmlspecialchars($c['vehicle_type']) . '</small>';
                echo '</div>';
                echo '</a>';
              }
            } else {
              echo '<p class="muted">No clients found. <a href="client.php">Create one first</a></p>';
            }
            ?>
          </div>
        <?php endif; ?>
      </section>
    </div>
  </main>

  <script src="carw.js"></script>
  <script>
    (function(){
      const attendeeSelect = document.getElementById('attendeeSelect');
      const roleInfo = document.getElementById('attendeeRoleInfo');
      const roleSpan = document.getElementById('attRole');
      const bookBtn = document.getElementById('bookBtn');
      const modal = document.getElementById('confirmModal');
      const backdrop = document.getElementById('modalBackdrop');
      const confirmYes = document.getElementById('confirmYes');
      const confirmNo = document.getElementById('confirmNo');
      const confirmBody = document.getElementById('confirmBody');
      const form = document.querySelector('form');

      function updateRole(){
        const opt = attendeeSelect.options[attendeeSelect.selectedIndex];
        const role = opt ? opt.getAttribute('data-role') : '';
        if (role) {
          roleSpan.textContent = role;
          roleInfo.style.display = '';
        } else {
          roleSpan.textContent = '';
          roleInfo.style.display = 'none';
        }
      }

      if (attendeeSelect) attendeeSelect.addEventListener('change', updateRole);
      updateRole();

      function showModal(){
        const client = document.querySelector('input[name="client_id"]').value || '';
        const serviceOpt = document.querySelector('select[name="service_id"]');
        const serviceText = serviceOpt.options[serviceOpt.selectedIndex] ? serviceOpt.options[serviceOpt.selectedIndex].text : '';
        const scheduled = document.querySelector('input[name="scheduled_at"]').value || '';
        confirmBody.textContent = `Client ID: ${client} — Service: ${serviceText} — When: ${scheduled}`;
        modal.style.display = 'block';
        backdrop.style.display = 'block';
      }

      function hideModal(){
        modal.style.display = 'none';
        backdrop.style.display = 'none';
      }

      bookBtn && bookBtn.addEventListener('click', function(){
        // basic validation
        const service = document.querySelector('select[name="service_id"]').value;
        const scheduled = document.querySelector('input[name="scheduled_at"]').value;
        if (!service || !scheduled) {
          alert('Please select a service and schedule date/time.');
          return;
        }
        showModal();
      });

      confirmNo && confirmNo.addEventListener('click', hideModal);
      backdrop && backdrop.addEventListener('click', hideModal);
      confirmYes && confirmYes.addEventListener('click', function(){
        // submit the form normally
        hideModal();
        form.submit();
      });
    })();
  </script>
</body>
</html>
