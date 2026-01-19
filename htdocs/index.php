<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMPP Codespace - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container-xl py-4">
            <!-- Header -->
            <div class="card mb-4">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 mb-3">
                        <i class="ti ti-rocket me-2 text-primary"></i>
                        Welcome to XAMPP Codespace
                    </h1>
                    <p class="text-muted fs-4">Your cloud-based PHP development environment is ready!</p>
                </div>
            </div>

            <!-- Quick Action Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-primary-lt rounded me-3">
                                    <i class="ti ti-database fs-1"></i>
                                </div>
                                <h3 class="card-title mb-0">phpMyAdmin</h3>
                            </div>
                            <p class="text-muted mb-3">Manage your MySQL databases with a user-friendly interface.</p>
                            <div class="mb-3">
                                <strong>Access:</strong> Port 8080<br>
                                <strong>Username:</strong> <code>root</code><br>
                                <strong>Password:</strong> <code>root</code>
                            </div>
                            <a href="http://localhost:8080" target="_blank" class="btn btn-primary w-100">
                                <i class="ti ti-external-link me-1"></i>
                                Open phpMyAdmin
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-info-lt rounded me-3">
                                    <i class="ti ti-info-circle fs-1"></i>
                                </div>
                                <h3 class="card-title mb-0">PHP Info</h3>
                            </div>
                            <p class="text-muted mb-3">View detailed PHP configuration, loaded extensions, and environment settings.</p>
                            <a href="info.php" class="btn btn-info w-100 mt-auto">
                                <i class="ti ti-eye me-1"></i>
                                View PHP Info
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-success-lt rounded me-3">
                                    <i class="ti ti-heartbeat fs-1"></i>
                                </div>
                                <h3 class="card-title mb-0">Health Check</h3>
                            </div>
                            <p class="text-muted mb-3">Verify that all services are running correctly and database connectivity is working.</p>
                            <a href="health.php" class="btn btn-success w-100 mt-auto">
                                <i class="ti ti-health-recognition me-1"></i>
                                Run Health Check
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar avatar-lg bg-warning-lt rounded me-3">
                                    <i class="ti ti-books fs-1"></i>
                                </div>
                                <h3 class="card-title mb-0">Examples</h3>
                            </div>
                            <p class="text-muted mb-3">Browse sample PHP-MySQL projects including CRUD operations, forms, and sessions.</p>
                            <a href="examples/" class="btn btn-warning w-100 mt-auto">
                                <i class="ti ti-code me-1"></i>
                                View Examples
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-list me-2"></i>
                        System Status
                    </h3>
                </div>
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">PHP Version</div>
                            <div class="col-auto">
                                <span class="badge bg-success"><?php echo phpversion(); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">Web Server</div>
                            <div class="col-auto">
                                <span class="badge bg-success"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">Document Root</div>
                            <div class="col-auto">
                                <code><?php echo $_SERVER['DOCUMENT_ROOT']; ?></code>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">Database Connection</div>
                            <div class="col-auto">
                                <?php
                                try {
                                    $conn = new mysqli('mysql', 'root', 'root', 'students_db');
                                    if ($conn->connect_error) {
                                        echo '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Failed</span>';
                                    } else {
                                        echo '<span class="badge bg-success"><i class="ti ti-check me-1"></i>Connected</span>';
                                        $conn->close();
                                    }
                                } catch (Exception $e) {
                                    echo '<span class="badge bg-danger"><i class="ti ti-x me-1"></i>Failed</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">Current Time</div>
                            <div class="col-auto">
                                <span class="text-muted"><?php echo date('Y-m-d H:i:s'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
