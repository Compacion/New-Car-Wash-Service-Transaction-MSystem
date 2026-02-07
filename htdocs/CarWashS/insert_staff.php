<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staff_name = mysqli_real_escape_string($conn, $_POST['staff_name'] ?? '');
    $role = mysqli_real_escape_string($conn, $_POST['role'] ?? 'staff');
    $phone = mysqli_real_escape_string($conn, $_POST['phone'] ?? '');

    if ($staff_name !== '') {
        $sql = "INSERT INTO staff (staff_name, role, phone) VALUES ('$staff_name', '$role', '$phone')";
        if (mysqli_query($conn, $sql)) {
            header('Location: staff.php');
            exit;
        } else {
            header('Location: staff.php?error=sql');
            exit;
        }
    } else {
        header('Location: staff.php?error=missing');
        exit;
    }
}

?>
