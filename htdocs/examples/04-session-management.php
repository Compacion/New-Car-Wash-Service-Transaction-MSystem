<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Management Example</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
        <div class="container-xl py-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="display-6 mb-2">
                        <i class="ti ti-lock me-2 text-purple"></i>
                        Session Management Example
                    </h1>
                    <p class="text-muted">Learn how to work with PHP sessions for user authentication and data persistence.</p>
                </div>
            </div>

            <?php
            // Start session
            session_start();

            $message = '';

            // Handle logout
            if (isset($_GET['action']) && $_GET['action'] === 'logout') {
                session_destroy();
                header('Location: 04-session-management.php');
                exit;
            }

            // Handle login
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
                if ($_POST['action'] === 'login') {
                    $username = trim($_POST['username'] ?? '');
                    $password = $_POST['password'] ?? '';
                    
                    // Simple authentication (in real app, check against database with hashed password)
                    if ($username === 'student' && $password === 'password123') {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['login_time'] = date('Y-m-d H:i:s');
                        $_SESSION['page_views'] = 0;
                        $message = '<div class="alert alert-success"><i class="ti ti-check me-2"></i>Login successful! Welcome, ' . htmlspecialchars($username) . '!</div>';
                    } else {
                        $message = '<div class="alert alert-danger"><i class="ti ti-x me-2"></i>Invalid username or password. Try: student / password123</div>';
                    }
                }
                
                // Handle session data update
                elseif ($_POST['action'] === 'update_preference') {
                    $_SESSION['theme'] = $_POST['theme'] ?? 'light';
                    $_SESSION['language'] = $_POST['language'] ?? 'en';
                    $message = '<div class="alert alert-success"><i class="ti ti-check me-2"></i>Preferences updated!</div>';
                }
            }

            // Track page views
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
                $_SESSION['page_views'] = ($_SESSION['page_views'] ?? 0) + 1;
            }

            echo $message;
            ?>

            <?php if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
                <!-- Login Form -->
                <div class="alert alert-info mb-3">
                    <i class="ti ti-info-circle me-2"></i>
                    This example demonstrates session-based authentication. Use these credentials to login:
                    <br><strong>Username:</strong> student | <strong>Password:</strong> password123
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Login</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="login">
                            
                            <div class="mb-3">
                                <label class="form-label required" for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label required" for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            
                            <button type="submit" class="btn btn-purple">
                                <i class="ti ti-login me-1"></i>
                                Login
                            </button>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <!-- User Dashboard -->
                <div class="card mb-3 border-start border-purple border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg bg-purple text-white me-3">
                                <i class="ti ti-user fs-1"></i>
                            </div>
                            <div>
                                <h3 class="mb-1">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
                                <p class="text-muted mb-0">You are currently logged in.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="ti ti-chart-bar me-2"></i>
                            Current Session Data
                        </h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <tbody>
                                <tr>
                                    <td class="fw-bold" style="width: 40%;">Session ID:</td>
                                    <td><code><?php echo session_id(); ?></code></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Username:</td>
                                    <td><?php echo htmlspecialchars($_SESSION['username']); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Login Time:</td>
                                    <td><?php echo $_SESSION['login_time']; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Page Views This Session:</td>
                                    <td><span class="badge bg-blue"><?php echo $_SESSION['page_views']; ?></span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Theme Preference:</td>
                                    <td><?php echo $_SESSION['theme'] ?? '<span class="text-muted">Not set</span>'; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Language Preference:</td>
                                    <td><?php echo $_SESSION['language'] ?? '<span class="text-muted">Not set</span>'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Update Session Preferences</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="update_preference">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="theme">Theme</label>
                                    <select id="theme" name="theme" class="form-select">
                                        <option value="light" <?php echo ($_SESSION['theme'] ?? '') === 'light' ? 'selected' : ''; ?>>Light</option>
                                        <option value="dark" <?php echo ($_SESSION['theme'] ?? '') === 'dark' ? 'selected' : ''; ?>>Dark</option>
                                        <option value="auto" <?php echo ($_SESSION['theme'] ?? '') === 'auto' ? 'selected' : ''; ?>>Auto</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="language">Language</label>
                                    <select id="language" name="language" class="form-select">
                                        <option value="en" <?php echo ($_SESSION['language'] ?? '') === 'en' ? 'selected' : ''; ?>>English</option>
                                        <option value="es" <?php echo ($_SESSION['language'] ?? '') === 'es' ? 'selected' : ''; ?>>Spanish</option>
                                        <option value="fr" <?php echo ($_SESSION['language'] ?? '') === 'fr' ? 'selected' : ''; ?>>French</option>
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy me-1"></i>
                                Update Preferences
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mb-3">
                    <a href="?action=logout" class="btn btn-danger">
                        <i class="ti ti-logout me-1"></i>
                        Logout
                    </a>
                </div>
            <?php endif; ?>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-code me-2"></i>
                        Session Code Examples
                    </h3>
                </div>
                <div class="card-body">
                    <h4 class="mb-3">Starting a Session:</h4>
                    <pre class="bg-dark text-white p-3 rounded mb-4"><code>// Start session at the beginning of your script
session_start();

// Set session variables
$_SESSION['username'] = 'student';
$_SESSION['user_id'] = 1;
$_SESSION['role'] = 'student';</code></pre>

                    <h4 class="mb-3">Checking Session Variables:</h4>
                    <pre class="bg-dark text-white p-3 rounded mb-4"><code>// Check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    echo "Welcome, " . $_SESSION['username'];
} else {
    header('Location: login.php');
    exit;
}</code></pre>

                    <h4 class="mb-3">Destroying a Session:</h4>
                    <pre class="bg-dark text-white p-3 rounded mb-0"><code>// Logout - destroy all session data
session_start();
session_destroy();
header('Location: index.php');
exit;</code></pre>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="03-form-handling.php" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Previous: Form Handling
                </a>
                <a href="index.php" class="btn">
                    Back to Examples
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
