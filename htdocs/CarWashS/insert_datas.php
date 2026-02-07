<?php
include("db_connect.php");

if (isset($_POST['submit'])) {
    $client_name   = mysqli_real_escape_string($conn, $_POST['client_name']);
    $phone_number  = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $plate_number  = mysqli_real_escape_string($conn, $_POST['plate_number']);
    $vehicle_type  = mysqli_real_escape_string($conn, $_POST['vehicle_type']);

    $sql = "INSERT INTO client (client_name, phone_number, plate_number, vehicle_type)
            VALUES ('$client_name', '$phone_number', '$plate_number', '$vehicle_type')";

    if (mysqli_query($conn, $sql)) {
        $client_id = mysqli_insert_id($conn);
        // Redirect to booking page to choose service for this client
        header('Location: book_service.php?client_id=' . intval($client_id));
        exit;
    } else {
        header('Location: client.php?error=sql');
        exit;
    }
}
?>
