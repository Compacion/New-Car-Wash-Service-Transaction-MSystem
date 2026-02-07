<?php
// Dashboard - Main landing page for Car Wash System
include 'db_connect.php';

// Get statistics
$stats = [];

// Total Services
$sql = "SELECT COUNT(*) as total FROM services";
$res = mysqli_query($conn, $sql);
$stats['services'] = mysqli_fetch_assoc($res)['total'] ?? 0;

// Total Clients
$sql = "SELECT COUNT(*) as total FROM clients";
$res = mysqli_query($conn, $sql);
$stats['clients'] = mysqli_fetch_assoc($res)['total'] ?? 0;

// Total Staff
$sql = "SELECT COUNT(*) as total FROM staff";
$res = mysqli_query($conn, $sql);
$stats['staff'] = mysqli_fetch_assoc($res)['total'] ?? 0;

// Total Bookings (if booking table exists)
$sql = "SELECT COUNT(*) as total FROM bookings";
$res = mysqli_query($conn, $sql);
$stats['bookings'] = mysqli_fetch_assoc($res)['total'] ?? 0;

// Recent bookings for dashboard
$recent_bookings = [];
$sql = "SELECT b.booking_id, c.client_name, s.name as service_name, b.booking_date FROM bookings b 
        JOIN clients c ON b.client_id = c.client_id 
        JOIN services s ON b.service_id = s.service_id 
        ORDER BY b.booking_date DESC LIMIT 5";
$res = mysqli_query($conn, $sql);
if ($res && mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $recent_bookings[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - The Crew Car Wash</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include 'navigation.php'; ?>

    <main class="main-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <h1>Dashboard</h1>
                <p class="header-subtitle">Welcome to The Crew Car Wash Management System</p>
            </div>
            <div class="header-actions">
                <button class="btn secondary" onclick="location.href='book_service.php'">
                    <span class="icon">📅</span> Book Service
                </button>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon services">🛁</div>
                <div class="stat-content">
                    <h3>Total Services</h3>
                    <p class="stat-value"><?php echo $stats['services']; ?></p>
                    <a href="homepage.php" class="stat-link">View all →</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon clients">👥</div>
                <div class="stat-content">
                    <h3>Total Clients</h3>
                    <p class="stat-value"><?php echo $stats['clients']; ?></p>
                    <a href="client.php" class="stat-link">Manage clients →</a>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon staff">👨‍💼</div>
                <div class="stat-content">
                    <h3>Staff Members</h3>
                    <p class="stat-value"><?php echo $stats['staff']; ?></p>
                    <a href="staff.php" class="stat-link">View staff →</a>
                </div>
            </div>

            <div class="stat-card" onclick="location.href='book_service.php'" style="cursor:pointer">
                <div class="stat-icon bookings">📋</div>
                <div class="stat-content">
                    <h3>Total Bookings</h3>
                    <a href="book_service.php" class="stat-value" style="text-decoration:none;color:inherit"><?php echo $stats['bookings']; ?></a>
                    <div style="margin-top:6px"><a href="book_service.php" class="stat-link">View bookings →</a></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-section">
            <h2>Quick Actions</h2>
            <div class="quick-actions">
                <a href="client.php" class="quick-action-card">
                    <span class="action-icon">➕</span>
                    <span class="action-title">Add Client</span>
                    <span class="action-desc">Register new client</span>
                </a>
                <a href="staff.php" class="quick-action-card">
                    <span class="action-icon">➕</span>
                    <span class="action-title">Add Staff</span>
                    <span class="action-desc">Hire new staff member</span>
                </a>
                <a href="homepage.php" class="quick-action-card">
                    <span class="action-icon">➕</span>
                    <span class="action-title">Add Service</span>
                    <span class="action-desc">Create new service</span>
                </a>
                <a href="book_service.php" class="quick-action-card">
                    <span class="action-icon">📅</span>
                    <span class="action-title">Book Service</span>
                    <span class="action-desc">Schedule appointment</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2>Recent Bookings</h2>
            <?php if (!empty($recent_bookings)): ?>
                <div class="activity-list">
                    <?php foreach ($recent_bookings as $booking): ?>
                        <div class="activity-item">
                            <div class="activity-avatar">📅</div>
                            <div class="activity-details">
                                <h4><?php echo htmlspecialchars($booking['client_name']); ?></h4>
                                <p><?php echo htmlspecialchars($booking['service_name']); ?></p>
                                <span class="activity-time"><?php echo htmlspecialchars($booking['booking_date']); ?></span>
                            </div>
                            <div class="activity-status">
                                <span class="badge badge-success">Scheduled</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="muted">No recent bookings. <a href="book_service.php">Create one now</a></p>
            <?php endif; ?>
        </div>
    </main>

    <script src="carw.js"></script>
</body>
</html>
