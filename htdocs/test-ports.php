<?php
header('Content-Type: text/html; charset=utf-8');

// Port 80 - Apache (always working if this page loads)
$apache_status = 'success';

// Port 3306 - MySQL
$mysql_status = 'error';
$mysql_message = '';
$mysql_version = '';

try {
    $mysqli = new mysqli('mysql', 'root', 'root', 'students_db');
    if ($mysqli->connect_error) {
        throw new Exception($mysqli->connect_error);
    }
    $result = $mysqli->query("SELECT VERSION() as version");
    $row = $result->fetch_assoc();
    $mysql_version = $row['version'];
    
    $result = $mysqli->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    $user_count = $row['count'];
    
    $mysql_status = 'success';
    $mysql_message = "Connected successfully! Database has {$user_count} users.";
    $mysqli->close();
} catch (Exception $e) {
    $mysql_message = "Connection failed: " . $e->getMessage();
}

// Port 8080 - phpMyAdmin
$phpmyadmin_status = 'warning';
$phpmyadmin_message = '';

$ch = curl_init('http://phpmyadmin/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
curl_setopt($ch, CURLOPT_NOBODY, true);
$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code == 200) {
    $phpmyadmin_status = 'success';
    $phpmyadmin_message = 'phpMyAdmin is running and accessible!';
} else {
    $phpmyadmin_message = 'phpMyAdmin container is not responding.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Port Status Check</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
        <div class="container-xl py-4">
            <div class="card mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="display-6 mb-2">
                        <i class="ti ti-zoom-check me-2 text-primary"></i>
                        Port Status Check
                    </h1>
                    <p class="text-muted">Testing Apache, MySQL, and phpMyAdmin connectivity</p>
                </div>
            </div>

            <!-- Port 80 - Apache -->
            <div class="card mb-3 border-start border-success border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar bg-success-lt">
                                <i class="ti ti-server"></i>
                            </span>
                        </div>
                        <div class="col">
                            <h3 class="card-title mb-1">Port 80 - Apache Web Server</h3>
                            <div class="text-success fw-bold mb-2">Working correctly!</div>
                            <div class="text-muted small">
                                <strong>Document Root:</strong> <code>/workspace/htdocs</code><br>
                                <strong>Access:</strong> You're viewing this page right now<br>
                                <strong>PHP Version:</strong> <?php echo phpversion(); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-success badge-pill">
                                <i class="ti ti-check me-1"></i>Online
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Port 3306 - MySQL -->
            <div class="card mb-3 border-start border-<?php echo $mysql_status == 'success' ? 'success' : 'danger'; ?> border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar bg-<?php echo $mysql_status == 'success' ? 'success' : 'danger'; ?>-lt">
                                <i class="ti ti-database"></i>
                            </span>
                        </div>
                        <div class="col">
                            <h3 class="card-title mb-1">Port 3306 - MySQL Database</h3>
                            <div class="text-<?php echo $mysql_status == 'success' ? 'success' : 'danger'; ?> fw-bold mb-2">
                                <?php echo $mysql_message; ?>
                            </div>
                            <?php if ($mysql_status == 'success'): ?>
                            <div class="text-muted small">
                                <strong>MySQL Version:</strong> <?php echo $mysql_version; ?><br>
                                <strong>Host:</strong> <code>mysql</code> (Docker container)<br>
                                <strong>Database:</strong> <code>students_db</code>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-<?php echo $mysql_status == 'success' ? 'success' : 'danger'; ?> badge-pill">
                                <i class="ti ti-<?php echo $mysql_status == 'success' ? 'check' : 'x'; ?> me-1"></i>
                                <?php echo $mysql_status == 'success' ? 'Online' : 'Offline'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Port 8080 - phpMyAdmin -->
            <div class="card mb-3 border-start border-<?php echo $phpmyadmin_status == 'success' ? 'success' : 'warning'; ?> border-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="avatar bg-<?php echo $phpmyadmin_status == 'success' ? 'success' : 'warning'; ?>-lt">
                                <i class="ti ti-brand-php"></i>
                            </span>
                        </div>
                        <div class="col">
                            <h3 class="card-title mb-1">Port 8080 - phpMyAdmin</h3>
                            <div class="text-<?php echo $phpmyadmin_status == 'success' ? 'success' : 'warning'; ?> fw-bold mb-2">
                                <?php echo $phpmyadmin_message; ?>
                            </div>
                            <?php if ($phpmyadmin_status == 'success'): ?>
                            <div class="text-muted small">
                                <strong>Container:</strong> Running on <code>phpmyadmin</code><br>
                                <strong>Access:</strong> Use the PORTS tab in VS Code to access phpMyAdmin
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-<?php echo $phpmyadmin_status == 'success' ? 'success' : 'warning'; ?> badge-pill">
                                <i class="ti ti-<?php echo $phpmyadmin_status == 'success' ? 'check' : 'alert-triangle'; ?> me-1"></i>
                                <?php echo $phpmyadmin_status == 'success' ? 'Online' : 'Warning'; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="card mb-3 bg-azure-lt">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-info-circle me-2"></i>
                        How to Access Each Port
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2"><strong>Port 80 (Apache):</strong> Click the forwarded URL in the PORTS tab, or you're already here!</li>
                        <li class="mb-2"><strong>Port 3306 (MySQL):</strong> Connect from PHP code using host: <code>mysql</code>, user: <code>root</code>, password: <code>root</code></li>
                        <li><strong>Port 8080 (phpMyAdmin):</strong> Click the forwarded URL in the PORTS tab. Login with username: <code>root</code>, password: <code>root</code></li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-tool me-2"></i>
                        Important Notes
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li class="mb-2">All three services are running in separate Docker containers</li>
                        <li class="mb-2">Ports 3306 and 8080 are accessible from your browser via VS Code's port forwarding</li>
                        <li class="mb-2">Inside this container, use hostname <code>mysql</code> or <code>phpmyadmin</code> to connect to other containers</li>
                        <li>The document root has been fixed to <code>/workspace/htdocs</code></li>
                    </ul>
                </div>
                <div class="card-footer text-muted">
                    Last checked: <?php echo date('Y-m-d H:i:s'); ?>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="index.php" class="btn btn-primary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
