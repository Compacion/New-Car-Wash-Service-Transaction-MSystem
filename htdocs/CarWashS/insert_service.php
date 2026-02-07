<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: homepage.php');
  exit;
}
require 'db_connect.php';
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$price = isset($_POST['price']) ? trim($_POST['price']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
if ($name === '' || $price === '') {
  header('Location: homepage.php');
  exit;
}
$stmt = mysqli_prepare($conn, "INSERT INTO services (name, price, description) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, 'sds', $name, $price, $description);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);
header('Location: homepage.php');
exit;
