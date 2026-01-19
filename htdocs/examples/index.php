<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Examples</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
</head>
<body>
    <div class="page">
        <div class="container-xl py-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="display-6 mb-2">
                        <i class="ti ti-books me-2 text-primary"></i>
                        PHP & MySQL Examples
                    </h1>
                    <p class="text-muted mb-0">Learn by example - explore these sample projects to understand PHP and MySQL basics.</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-primary-lt mb-3">
                                    <i class="ti ti-database fs-1"></i>
                                </span>
                                <h3 class="card-title">Database Connection</h3>
                            </div>
                            <p class="text-muted mb-3 flex-grow-1">Learn how to connect to MySQL database using both mysqli and PDO.</p>
                            <a href="01-database-connection.php" class="btn btn-primary w-100">
                                <i class="ti ti-arrow-right me-1"></i>
                                View Example
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-success-lt mb-3">
                                    <i class="ti ti-edit fs-1"></i>
                                </span>
                                <h3 class="card-title">CRUD Operations</h3>
                            </div>
                            <p class="text-muted mb-3 flex-grow-1">Complete Create, Read, Update, Delete operations with user management.</p>
                            <a href="02-crud-operations.php" class="btn btn-success w-100">
                                <i class="ti ti-arrow-right me-1"></i>
                                View Example
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-warning-lt mb-3">
                                    <i class="ti ti-forms fs-1"></i>
                                </span>
                                <h3 class="card-title">Form Handling</h3>
                            </div>
                            <p class="text-muted mb-3 flex-grow-1">Process HTML forms with validation and sanitization.</p>
                            <a href="03-form-handling.php" class="btn btn-warning w-100">
                                <i class="ti ti-arrow-right me-1"></i>
                                View Example
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card card-hover h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <span class="avatar avatar-lg bg-info-lt mb-3">
                                    <i class="ti ti-lock fs-1"></i>
                                </span>
                                <h3 class="card-title">Session Management</h3>
                            </div>
                            <p class="text-muted mb-3 flex-grow-1">Work with PHP sessions for user authentication and data persistence.</p>
                            <a href="04-session-management.php" class="btn btn-info w-100">
                                <i class="ti ti-arrow-right me-1"></i>
                                View Example
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="../index.php" class="btn btn-outline-primary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
