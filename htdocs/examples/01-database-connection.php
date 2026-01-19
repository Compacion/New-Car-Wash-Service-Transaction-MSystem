<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Example</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
      <div class="container-xl py-4">
        <div class="card mb-4">
          <div class="card-body">
            <h1 class="display-6 mb-2">
              <i class="ti ti-database me-2 text-primary"></i>
              Database Connection Example
            </h1>
            <p class="text-muted">This example demonstrates how to connect to MySQL database using both MySQLi and PDO.</p>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">
            <h3 class="card-title">Method 1: MySQLi (Object-Oriented)</h3>
          </div>
          <div class="card-body">
            <pre class="bg-dark text-white p-3 rounded"><code>// Database credentials
$host = 'mysql';
$username = 'root';
$password = 'root';
$database = 'students_db';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";

// Close connection
$conn->close();</code></pre>
          </div>
        </div>

        <div class="card mb-3 border-start border-success border-4">
          <div class="card-body">
            <?php
            // MySQLi connection
            $host = 'mysql';
            $username = 'root';
            $password = 'root';
            $database = 'students_db';

            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                echo '<div class="alert alert-danger"><i class="ti ti-x me-2"></i>MySQLi Connection failed: ' . $conn->connect_error . '</div>';
            } else {
                echo '<div class="text-success mb-2"><i class="ti ti-check me-2"></i><strong>MySQLi Connection successful!</strong></div>';
                echo '<p class="mb-1"><strong>Server Info:</strong> ' . $conn->server_info . '</p>';
                echo '<p class="mb-0"><strong>Host Info:</strong> ' . $conn->host_info . '</p>';
                $conn->close();
            }
            ?>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">
            <h3 class="card-title">Method 2: PDO (PHP Data Objects)</h3>
          </div>
          <div class="card-body">
            <pre class="bg-dark text-white p-3 rounded"><code>// Database credentials
$host = 'mysql';
$username = 'root';
$password = 'root';
$database = 'students_db';

try {
    $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}</code></pre>
          </div>
        </div>

        <div class="card mb-3 border-start border-success border-4">
          <div class="card-body">
            <?php
            // PDO connection
            try {
                $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
                $pdo = new PDO($dsn, $username, $password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                echo '<div class="text-success mb-2"><i class="ti ti-check me-2"></i><strong>PDO Connection successful!</strong></div>';
                echo '<p class="mb-1"><strong>Server Version:</strong> ' . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . '</p>';
                echo '<p class="mb-0"><strong>Driver:</strong> ' . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . '</p>';
            } catch(PDOException $e) {
                echo '<div class="alert alert-danger"><i class="ti ti-x me-2"></i>PDO Connection failed: ' . $e->getMessage() . '</div>';
            }
            ?>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">
            <h3 class="card-title">Sample Query: Fetch Users</h3>
          </div>
          <div class="card-body">
            <pre class="bg-dark text-white p-3 rounded"><code>// Using MySQLi
$result = $conn->query("SELECT * FROM users");
while($row = $result->fetch_assoc()) {
    echo $row['username'];
}

// Using PDO
$stmt = $pdo->query("SELECT * FROM users");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo $row['username'];
}</code></pre>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-body">
            <?php
            // Fetch and display users
            try {
                $conn = new mysqli($host, $username, $password, $database);
                $result = $conn->query("SELECT id, username, email, full_name FROM users");
                
                if ($result && $result->num_rows > 0) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-vcenter card-table">';
                    echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th></tr></thead>';
                    echo '<tbody>';
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td><strong>' . htmlspecialchars($row['username']) . '</strong></td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo '<div class="text-muted">No users found.</div>';
                }
                $conn->close();
            } catch(Exception $e) {
                echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
            }
            ?>
          </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="index.php" class="btn btn-outline-primary">
              <i class="ti ti-arrow-left me-1"></i>
              Back to Examples
            </a>
            <a href="02-crud-operations.php" class="btn btn-primary">
              Next: CRUD Operations
              <i class="ti ti-arrow-right ms-1"></i>
            </a>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
