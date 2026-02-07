<?php
$servername = "mysql";
$username = "root";
$password = "root";
$database = "carwashservice_db";

// Connect to MySQL server (no default database) so we can create the DB if needed
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create database if it doesn't exist
$createDbSql = "CREATE DATABASE IF NOT EXISTS `" . mysqli_real_escape_string($conn, $database) . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (!mysqli_query($conn, $createDbSql)) {
    die("Failed to create database: " . mysqli_error($conn));
}

// Select the database
mysqli_select_db($conn, $database);

// Create client table if it doesn't exist
$createTable = "CREATE TABLE IF NOT EXISTS `client` (
  `client_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `client_name` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(32) DEFAULT NULL,
  `plate_number` VARCHAR(64) DEFAULT NULL,
  `vehicle_type` VARCHAR(64) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $createTable)) {
    die("Failed to create client table: " . mysqli_error($conn));
}

// Create staff table if it doesn't exist
$createStaff = "CREATE TABLE IF NOT EXISTS `staff` (
    `staff_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `staff_name` VARCHAR(255) NOT NULL,
    `role` VARCHAR(128) DEFAULT 'staff',
    `phone` VARCHAR(32) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $createStaff)) {
        die("Failed to create staff table: " . mysqli_error($conn));
}

// Create services table
$createServices = "CREATE TABLE IF NOT EXISTS `services` (
    `service_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(128) NOT NULL,
    `description` TEXT DEFAULT NULL,
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `duration_minutes` INT DEFAULT 30,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if (!mysqli_query($conn, $createServices)) {
        die("Failed to create services table: " . mysqli_error($conn));
}

// Seed some default services if table empty
$res = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM services");
$row = mysqli_fetch_assoc($res);
if (intval($row['cnt']) === 0) {
        $seed = [
                ["Basic Wash", "Exterior wash and dry", "50.00", 20],
                ["Premium Wash", "Exterior + interior vacuum and polish", "120.00", 40],
                ["Deluxe Package", "Full service + waxing", "200.00", 60]
        ];
        $stmt = mysqli_prepare($conn, "INSERT INTO services (name, description, price, duration_minutes) VALUES (?, ?, ?, ?)");
        foreach ($seed as $s) {
                mysqli_stmt_bind_param($stmt, 'ssdi', $s[0], $s[1], $s[2], $s[3]);
                mysqli_stmt_execute($stmt);
        }
        mysqli_stmt_close($stmt);
}

// Create bookings table
$createBookings = "CREATE TABLE IF NOT EXISTS `bookings` (
    `booking_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `client_id` INT NOT NULL,
    `service_id` INT NOT NULL,
    `staff_id` INT DEFAULT NULL,
    `scheduled_at` DATETIME DEFAULT NULL,
    `status` VARCHAR(32) DEFAULT 'booked',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES client(client_id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE,
    FOREIGN KEY (staff_id) REFERENCES staff(staff_id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if (!mysqli_query($conn, $createBookings)) {
        die("Failed to create bookings table: " . mysqli_error($conn));
}

// Create payments table
$createPayments = "CREATE TABLE IF NOT EXISTS `payments` (
    `payment_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `booking_id` INT NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `method` VARCHAR(64) DEFAULT 'cash',
    `paid_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(booking_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if (!mysqli_query($conn, $createPayments)) {
        die("Failed to create payments table: " . mysqli_error($conn));
}

// db_connect.php intentionally sends no output to allow including files to
// perform redirects (header()) without "headers already sent" warnings.
// If you need a debug message, enable it conditionally or log to a file.