<?php
include('db_connect.php');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: staff.php'); exit; }

$client_id = intval($_POST['client_id'] ?? 0);
$service_id = intval($_POST['service_id'] ?? 0);
$staff_id = !empty($_POST['staff_id']) ? intval($_POST['staff_id']) : 'NULL';
$scheduled_at = !empty($_POST['scheduled_at']) ? mysqli_real_escape_string($conn, $_POST['scheduled_at']) : NULL;

if ($client_id <= 0 || $service_id <= 0) {
    header('Location: book_service.php?client_id=' . intval($client_id) . '&error=missing');
    exit;
}

$sql = "INSERT INTO bookings (client_id, service_id, staff_id, scheduled_at) VALUES ($client_id, $service_id, " . ($staff_id === 'NULL' ? 'NULL' : $staff_id) . ", " . ($scheduled_at ? "'". $scheduled_at ."'" : 'NULL') . ")";
if (mysqli_query($conn, $sql)) {
    $booking_id = mysqli_insert_id($conn);
    header('Location: payment.php?booking_id=' . intval($booking_id)); exit;
} else {
    header('Location: book_service.php?client_id=' . intval($client_id) . '&error=sql');
    exit;
}

?>
