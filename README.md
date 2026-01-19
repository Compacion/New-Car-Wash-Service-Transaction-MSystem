# 🚀 XAMPP Codespace - Cloud-Based PHP Development Environment

[![Open in GitHub Codespaces](https://github.com/codespaces/badge.svg)](https://github.com/codespaces/new?hide_repo_select=true&ref=main&repo=ici-github/ICI-Github-XAMPP)

A complete **cloud-based XAMPP alternative** for students, providing PHP 8.1+, MySQL 8.0, and phpMyAdmin in GitHub Codespaces. No local installation required - just click and code!

## ✨ Features

- **PHP 8.1+** with Apache web server
- **MySQL 8.0** database with persistent storage
- **phpMyAdmin** for easy database management
- **Auto-start services** - everything ready when you open the codespace
- **Persistent data** - your databases survive codespace restarts
- **Pre-installed PHP extensions** - mysqli, pdo_mysql, gd, mbstring, zip, curl, intl, opcache
- **Sample projects** - CRUD operations, form handling, sessions, and more
- **Database management scripts** - easy backup, restore, and reset
- **VS Code extensions** - PHP Intelephense, MySQL client, GitHub Copilot

## 🎯 Quick Start

### Option 1: Use This Template
1. Click "Use this template" button at the top of this repository
2. Create your own repository from this template
3. Open your new repository in Codespaces

### Option 2: Open Directly
1. Click the "Open in Codespaces" badge above
2. Wait for the container to build (first time takes 2-3 minutes)
3. Access your web server through the forwarded port 80

## 📂 Directory Structure

```
ICI-Github-XAMPP/
├── .devcontainer/          # Dev container configuration
│   ├── devcontainer.json   # VS Code container settings
│   ├── docker-compose.yml  # Multi-service orchestration
│   ├── Dockerfile          # PHP + Apache container
│   ├── php.ini             # PHP configuration
│   ├── mysql-init/         # Database initialization
│   │   └── init.sql        # Creates students_db with sample data
│   └── scripts/            # Database management scripts
│       ├── export-db.sh    # Backup database
│       ├── import-db.sh    # Restore database
│       └── reset-db.sh     # Reset to initial state
├── htdocs/                 # Your web files go here (like htdocs in XAMPP)
│   ├── index.php           # Welcome page
│   ├── info.php            # PHP configuration info
│   ├── health.php          # System health check
│   └── examples/           # Sample PHP projects
│       ├── 01-database-connection.php
│       ├── 02-crud-operations.php
│       ├── 03-form-handling.php
│       └── 04-session-management.php
├── logs/                   # Apache and PHP error logs
└── backups/               # Database backups (created when you export)
```

## 🌐 Accessing Services

Once your codespace is running, you'll see forwarded ports in the **PORTS** tab:

| Service | Port | Access URL | Description |
|---------|------|------------|-------------|
| **Web Server** | 80 | Click "Open in Browser" | Your PHP applications |
| **phpMyAdmin** | 8080 | Click "Open in Browser" | Database management interface |
| **MySQL** | 3306 | Internal | Database connection from PHP |

> **Tip:** GitHub Codespaces automatically generates secure URLs for each port!

## 🔐 Database Credentials

Use these credentials to connect to MySQL:

- **Host:** `mysql` (from PHP) or `localhost` (from MySQL client)
- **Username:** `root`
- **Password:** `root`
- **Database:** `students_db` (pre-created with sample tables)

### Sample PHP Connection:
```php
$conn = new mysqli('mysql', 'root', 'root', 'students_db');
```

## 📝 Creating Your First PHP Page

1. Create a new file in the `htdocs/` folder (e.g., `htdocs/hello.php`)
2. Add your PHP code:
```php
<?php
echo "Hello, World!";
?>
```
3. Access it via your web server URL: `https://your-codespace-url/hello.php`

## 🛠️ Database Management Scripts

Located in `.devcontainer/scripts/`:

### Export Database
```bash
./.devcontainer/scripts/export-db.sh
```
Creates a timestamped backup in `backups/` folder.

### Import Database
```bash
./.devcontainer/scripts/import-db.sh /workspace/backups/students_db_20250115_120000.sql
```

### Reset Database
```bash
./.devcontainer/scripts/reset-db.sh
```
Restores database to initial state with sample data.

## 📚 Sample Projects

Explore the `htdocs/examples/` directory for learning resources:

1. **Database Connection** - Learn mysqli and PDO
2. **CRUD Operations** - Complete user management system
3. **Form Handling** - Validation and sanitization
4. **Session Management** - Authentication and user sessions

Access them at: `http://your-codespace-url/examples/`

## 🐛 Troubleshooting

### Services not starting?
Check the health status: `http://your-codespace-url/health.php`

### Database connection failed?
1. Verify MySQL container is running: `docker ps`
2. Check logs: `docker logs <mysql-container-id>`

### Check error logs:
```bash
cat /workspace/logs/php-error.log
tail -f /workspace/logs/php-error.log  # Follow in real-time
```

### Restart Apache:
```bash
service apache2 restart
```

## 💾 Data Persistence

- **Database data** is stored in a Docker volume and persists across codespace stops/starts
- **Your PHP files** in `htdocs/` are part of the workspace and automatically saved
- **Codespace storage** is maintained as long as the codespace exists

> **Note:** Deleting the codespace will delete all data. Export your database before deletion!

## 🤝 Contributing

This is a template repository for educational purposes. Feel free to:
- Fork and customize for your needs
- Add more example projects
- Improve documentation
- Share with students

## 📖 Additional Resources

For detailed instructions and tutorials, see [HOWTOUSE.md](HOWTOUSE.md)

## 📄 License

This template is provided as-is for educational purposes.

---

**Made with ❤️ for students learning PHP and MySQL**