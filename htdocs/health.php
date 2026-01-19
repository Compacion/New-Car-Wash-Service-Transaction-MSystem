<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Health Check</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
        <div class="container-xl py-4">
            <div class="card mb-4">
                <div class="card-body text-center py-4">
                    <h1 class="display-6 mb-2">
                        <i class="ti ti-heartbeat me-2 text-danger"></i>
                        System Health Check
                    </h1>
                    <p class="text-muted">Checking all services and configurations</p>
                </div>
            </div>

            <?php
            $checks = [];
            
            // Check 1: PHP Version
            $phpVersion = phpversion();
            $phpOk = version_compare($phpVersion, '8.1.0', '>=');
            $checks[] = [
                'title' => 'PHP Version',
                'status' => $phpOk ? 'success' : 'danger',
                'message' => "PHP $phpVersion " . ($phpOk ? '✓' : '✗ (Requires 8.1+)'),
                'icon' => $phpOk ? 'check' : 'x'
            ];

            // Check 2: Database Connection
            $dbOk = false;
            $dbMessage = '';
            try {
                $conn = new mysqli('mysql', 'root', 'root', 'students_db');
                if ($conn->connect_error) {
                    $dbMessage = "Connection failed: " . $conn->connect_error;
                } else {
                    $dbOk = true;
                    $dbMessage = "Connected successfully to 'students_db'";
                    $conn->close();
                }
            } catch (Exception $e) {
                $dbMessage = "Error: " . $e->getMessage();
            }
            $checks[] = [
                'title' => 'MySQL Database Connection',
                'status' => $dbOk ? 'success' : 'danger',
                'message' => $dbMessage,
                'icon' => $dbOk ? 'check' : 'x'
            ];

            // Check 3: Required PHP Extensions
            $requiredExtensions = ['mysqli', 'pdo_mysql', 'gd', 'mbstring', 'zip', 'curl', 'intl'];
            $missingExtensions = [];
            foreach ($requiredExtensions as $ext) {
                if (!extension_loaded($ext)) {
                    $missingExtensions[] = $ext;
                }
            }
            $extensionsOk = empty($missingExtensions);
            $checks[] = [
                'title' => 'Required PHP Extensions',
                'status' => $extensionsOk ? 'success' : 'danger',
                'message' => $extensionsOk 
                    ? 'All required extensions loaded (' . implode(', ', $requiredExtensions) . ')'
                    : 'Missing extensions: ' . implode(', ', $missingExtensions),
                'icon' => $extensionsOk ? 'check' : 'x'
            ];

            // Check 4: Write Permissions
            $logsDir = '/workspace/logs';
            $htdocsDir = '/workspace/htdocs';
            $logsWritable = is_writable($logsDir);
            $htdocsWritable = is_writable($htdocsDir);
            $permissionsOk = $logsWritable && $htdocsWritable;
            $checks[] = [
                'title' => 'Directory Permissions',
                'status' => $permissionsOk ? 'success' : 'warning',
                'message' => "logs: " . ($logsWritable ? '✓ writable' : '✗ not writable') . 
                            " | htdocs: " . ($htdocsWritable ? '✓ writable' : '✗ not writable'),
                'icon' => $permissionsOk ? 'check' : 'alert-triangle'
            ];

            // Check 5: PHP Configuration
            $uploadLimit = ini_get('upload_max_filesize');
            $memoryLimit = ini_get('memory_limit');
            $checks[] = [
                'title' => 'PHP Configuration',
                'status' => 'success',
                'message' => "upload_max_filesize: $uploadLimit | memory_limit: $memoryLimit",
                'icon' => 'check'
            ];

            // Display checks
            foreach ($checks as $check) {
                echo '<div class="card mb-3">';
                echo '<div class="card-body">';
                echo '<div class="row align-items-center">';
                echo '<div class="col-auto">';
                echo '<span class="avatar bg-' . $check['status'] . '-lt">';
                echo '<i class="ti ti-' . $check['icon'] . '"></i>';
                echo '</span>';
                echo '</div>';
                echo '<div class="col">';
                echo '<h3 class="card-title mb-1">' . $check['title'] . '</h3>';
                echo '<div class="text-muted">' . $check['message'] . '</div>';
                echo '</div>';
                echo '<div class="col-auto">';
                echo '<span class="badge bg-' . $check['status'] . '">';
                echo ($check['status'] == 'success' ? 'OK' : ($check['status'] == 'warning' ? 'Warning' : 'Error'));
                echo '</span>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            // Database Tables Check (if connected)
            if ($dbOk) {
                echo '<div class="card mb-3">';
                echo '<div class="card-header">';
                echo '<h3 class="card-title"><i class="ti ti-table me-2"></i>Database Tables</h3>';
                echo '</div>';
                echo '<div class="table-responsive">';
                echo '<table class="table card-table table-vcenter">';
                echo '<thead><tr><th>Table Name</th><th class="text-end">Row Count</th></tr></thead>';
                echo '<tbody>';
                try {
                    $conn = new mysqli('mysql', 'root', 'root', 'students_db');
                    $result = $conn->query("SHOW TABLES");
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_array()) {
                            $tableName = $row[0];
                            $countResult = $conn->query("SELECT COUNT(*) as count FROM $tableName");
                            $count = $countResult->fetch_assoc()['count'];
                            echo "<tr><td><code>$tableName</code></td><td class=\"text-end\"><span class=\"badge\">$count</span></td></tr>";
                        }
                    } else {
                        echo '<tr><td colspan="2" class="text-muted">No tables found</td></tr>';
                    }
                    $conn->close();
                } catch (Exception $e) {
                    echo '<tr><td colspan="2" class="text-danger">Error: ' . $e->getMessage() . '</td></tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                echo '</div>';
            }

            // Overall Status
            $allOk = $phpOk && $dbOk && $extensionsOk;
            echo '<div class="card bg-' . ($allOk ? 'success' : 'warning') . '-lt">';
            echo '<div class="card-body">';
            echo '<div class="d-flex align-items-center">';
            echo '<div class="avatar avatar-lg bg-' . ($allOk ? 'success' : 'warning') . ' text-white me-3">';
            echo '<i class="ti ti-' . ($allOk ? 'check' : 'alert-triangle') . ' fs-1"></i>';
            echo '</div>';
            echo '<div>';
            echo '<h3 class="mb-1">Overall Status</h3>';
            echo '<p class="mb-0">';
            echo $allOk 
                ? 'All systems operational! Your development environment is ready.' 
                : 'Some issues detected. Please review the checks above.';
            echo '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            ?>

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
