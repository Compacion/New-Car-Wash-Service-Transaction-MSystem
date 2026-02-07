<?php
include('db_connect.php');
$booking_id = isset($_GET['booking_id']) ? intval($_GET['booking_id']) : 0;
if (!$booking_id) { echo 'Invalid booking id'; exit; }
$booking = mysqli_fetch_assoc(mysqli_query($conn, "SELECT b.*, c.client_name, s.name AS service_name, s.price FROM bookings b JOIN client c ON b.client_id=c.client_id JOIN services s ON b.service_id=s.service_id WHERE b.booking_id=".$booking_id));
if (!$booking) { echo 'Booking not found'; exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payment - The Crew Car Wash</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'navigation.php'; ?>

  <main class="main-content">
    <div class="dashboard-header">
      <div class="header-content">
        <h1>Payment</h1>
        <p class="header-subtitle">Complete payment for booking #<?php echo $booking_id; ?></p>
      </div>
    </div>

    <div class="container" style="justify-content: center;">
      <section class="panel form-card" style="max-width: 500px;">
        <h2>Payment Details</h2>
        
        <div id="paymentSummary" style="background: rgba(51, 153, 204, 0.06); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border-left: 4px solid var(--accent);">
          <p style="margin: 0.5rem 0;"><strong>Client:</strong> <?php echo htmlspecialchars($booking['client_name']); ?></p>
          <?php if (!empty($booking['service_name'])): ?><p style="margin: 0.5rem 0;"><strong>Service:</strong> <?php echo htmlspecialchars($booking['service_name']); ?></p><?php endif; ?>
          <p style="margin: 0.5rem 0; font-size: 1.25rem; color: var(--accent-2);"><strong>Amount: $<?php echo number_format($booking['price'], 2); ?></strong></p>
          <div id="paymentMethodInfo" style="margin-top:6px;color:var(--muted);display:none">Payment Method: <span id="payMethod" style="font-weight:700;color:var(--accent-2)"></span></div>
        </div>

        <form method="post" action="insert_payment.php">
          <input type="hidden" name="booking_id" value="<?php echo $booking_id; ?>">
          
          <label>Amount to Pay</label>
          <input type="number" name="amount" step="0.01" value="<?php echo number_format($booking['price'], 2); ?>" required>

          <label>Payment Method</label>
          <select id="paymentMethod" name="method" required style="width: 100%; padding: 0.6rem; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); border-radius: 0.5rem; color: #eaf6f8; margin-top: 0.5rem;">
            <option value="cash">💵 Cash</option>
            <option value="card">💳 Card</option>
            <option value="check">✓ Check</option>
            <option value="other">Other</option>
          </select>

          <div class="form-actions">
            <button class="btn primary" type="submit">Complete Payment</button>
            <a href="book_service.php" class="btn ghost">Cancel</a>
          </div>
        </form>
      </section>
    </div>
  </main>

  <script src="carw.js"></script>
  <script>
    (function(){
      const pm = document.getElementById('paymentMethod');
      const info = document.getElementById('paymentMethodInfo');
      const span = document.getElementById('payMethod');
      function update(){
        if (!pm) return;
        const txt = pm.options[pm.selectedIndex].text;
        if (txt) { span.textContent = txt.replace(/^[^\s]+\s*/, ''); info.style.display = ''; }
        else { span.textContent = ''; info.style.display = 'none'; }
      }
      if (pm) { pm.addEventListener('change', update); update(); }
    })();
  </script>
</body>
</html>
