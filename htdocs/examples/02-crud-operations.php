<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Operations Example</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
        <div class="container-xl py-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="display-6 mb-2">
                        <i class="ti ti-edit me-2 text-success"></i>
                        CRUD Operations Example
                    </h1>
                    <p class="text-muted">Create, Read, Update, and Delete operations with the users table.</p>
                </div>
            </div>

            <?php
            // Database connection
            $conn = new mysqli('mysql', 'root', 'root', 'students_db');
            
            if ($conn->connect_error) {
                die('<div class="alert alert-danger"><i class="ti ti-x me-2"></i>Database connection failed: ' . $conn->connect_error . '</div>');
            }

            $message = '';
            $editUser = null;

            // Handle form submissions
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_POST['action'])) {
                    $action = $_POST['action'];
                    
                    // CREATE
                    if ($action === 'create') {
                        $username = $conn->real_escape_string($_POST['username']);
                        $email = $conn->real_escape_string($_POST['email']);
                        $fullName = $conn->real_escape_string($_POST['full_name']);
                        
                        $sql = "INSERT INTO users (username, email, full_name) VALUES ('$username', '$email', '$fullName')";
                        
                        if ($conn->query($sql)) {
                            $message = '<div class="alert alert-success alert-dismissible"><i class="ti ti-check me-2"></i>User created successfully!</div>';
                        } else {
                            $message = '<div class="alert alert-danger alert-dismissible"><i class="ti ti-x me-2"></i>Error: ' . $conn->error . '</div>';
                        }
                    }
                    
                    // UPDATE
                    elseif ($action === 'update') {
                        $id = (int)$_POST['id'];
                        $username = $conn->real_escape_string($_POST['username']);
                        $email = $conn->real_escape_string($_POST['email']);
                        $fullName = $conn->real_escape_string($_POST['full_name']);
                        
                        $sql = "UPDATE users SET username='$username', email='$email', full_name='$fullName' WHERE id=$id";
                        
                        if ($conn->query($sql)) {
                            $message = '<div class="alert alert-success alert-dismissible"><i class="ti ti-check me-2"></i>User updated successfully!</div>';
                        } else {
                            $message = '<div class="alert alert-danger alert-dismissible"><i class="ti ti-x me-2"></i>Error: ' . $conn->error . '</div>';
                        }
                    }
                    
                    // DELETE
                    elseif ($action === 'delete') {
                        $id = (int)$_POST['id'];
                        $sql = "DELETE FROM users WHERE id=$id";
                        
                        if ($conn->query($sql)) {
                            $message = '<div class="alert alert-success alert-dismissible"><i class="ti ti-check me-2"></i>User deleted successfully!</div>';
                        } else {
                            $message = '<div class="alert alert-danger alert-dismissible"><i class="ti ti-x me-2"></i>Error: ' . $conn->error . '</div>';
                        }
                    }
                }
            }

            // Handle edit request
            if (isset($_GET['edit'])) {
                $id = (int)$_GET['edit'];
                $result = $conn->query("SELECT * FROM users WHERE id=$id");
                if ($result && $result->num_rows > 0) {
                    $editUser = $result->fetch_assoc();
                }
            }

            echo $message;
            ?>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-<?php echo $editUser ? 'pencil' : 'plus'; ?> me-2"></i>
                        <?php echo $editUser ? 'Edit User' : 'Create New User'; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="<?php echo $editUser ? 'update' : 'create'; ?>">
                        <?php if ($editUser): ?>
                            <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Username</label>
                                <input type="text" class="form-control" name="username" required 
                                       value="<?php echo $editUser ? htmlspecialchars($editUser['username']) : ''; ?>"
                                       placeholder="Enter username">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Email</label>
                                <input type="email" class="form-control" name="email" required 
                                       value="<?php echo $editUser ? htmlspecialchars($editUser['email']) : ''; ?>"
                                       placeholder="email@example.com">
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" name="full_name" 
                                       value="<?php echo $editUser ? htmlspecialchars($editUser['full_name']) : ''; ?>"
                                       placeholder="Enter full name">
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-<?php echo $editUser ? 'warning' : 'success'; ?>">
                                <i class="ti ti-<?php echo $editUser ? 'device-floppy' : 'plus'; ?> me-1"></i>
                                <?php echo $editUser ? 'Update User' : 'Create User'; ?>
                            </button>
                            <?php if ($editUser): ?>
                                <a href="02-crud-operations.php" class="btn">
                                    <i class="ti ti-x me-1"></i>
                                    Cancel
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="ti ti-users me-2"></i>
                        All Users
                    </h3>
                </div>
                <?php
                // READ - Display all users
                $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
                
                if ($result && $result->num_rows > 0) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-vcenter card-table">';
                    echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Full Name</th><th>Created At</th><th class="w-1">Actions</th></tr></thead>';
                    echo '<tbody>';
                    
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td><span class="badge">' . $row['id'] . '</span></td>';
                        echo '<td><strong>' . htmlspecialchars($row['username']) . '</strong></td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['full_name']) . '</td>';
                        echo '<td><span class="text-muted">' . $row['created_at'] . '</span></td>';
                        echo '<td>';
                        echo '<div class="btn-list">';
                        echo '<a href="?edit=' . $row['id'] . '" class="btn btn-sm btn-warning">';
                        echo '<i class="ti ti-edit"></i> Edit';
                        echo '</a>';
                        echo '<form method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">';
                        echo '<input type="hidden" name="action" value="delete">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="btn btn-sm btn-danger">';
                        echo '<i class="ti ti-trash"></i> Delete';
                        echo '</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</td>';
                        echo '</tr>';
                    }
                    
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo '<div class="card-body">';
                    echo '<div class="empty">';
                    echo '<div class="empty-icon"><i class="ti ti-users"></i></div>';
                    echo '<p class="empty-title">No users found</p>';
                    echo '<p class="empty-subtitle text-muted">Create your first user using the form above.</p>';
                    echo '</div>';
                    echo '</div>';
                }

                $conn->close();
                ?>
            </div>

            <div class="d-flex gap-2">
                <a href="01-database-connection.php" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Previous: Database Connection
                </a>
                <a href="index.php" class="btn">
                    Back to Examples
                </a>
                <a href="03-form-handling.php" class="btn btn-primary">
                    Next: Form Handling
                    <i class="ti ti-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
