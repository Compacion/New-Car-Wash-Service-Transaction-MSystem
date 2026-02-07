<?php
include('db_connect.php');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: client.php'); exit; }
$booking_id = intval($_POST['booking_id'] ?? 0);
$amount = floatval($_POST['amount'] ?? 0);
$method = mysqli_real_escape_string($conn, $_POST['method'] ?? 'cash');
if ($booking_id <= 0 || $amount <= 0) {
    header('Location: payment.php?booking_id=' . intval($booking_id) . '&error=invalid');
    exit;
}
$sql = "INSERT INTO payments (booking_id, amount, method) VALUES ($booking_id, $amount, '$method')";
if (mysqli_query($conn, $sql)) {
    // mark booking as paid so it's not left stagnant
    mysqli_query($conn, "UPDATE bookings SET status='paid' WHERE booking_id = " . intval($booking_id));
    header('Location: client.php?paid=1'); exit;
} else {
    header('Location: payment.php?booking_id=' . intval($booking_id) . '&error=sql');
    exit;
}

?>
