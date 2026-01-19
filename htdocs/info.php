<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Configuration Information</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>
    <style>
        body { background-color: #f4f6fa; }
        .phpinfo-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-xl py-4">
        <div class="phpinfo-header">
            <h1 class="display-6 mb-2">
                <i class="ti ti-info-circle me-2"></i>
                PHP Configuration Information
            </h1>
            <p class="mb-3">PHP Version: <?php echo phpversion(); ?></p>
            <a href="index.php" class="btn btn-light">
                <i class="ti ti-arrow-left me-1"></i>
                Back to Home
            </a>
        </div>
        
        <div class="card">
            <div class="card-body">
                <?php phpinfo(); ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
