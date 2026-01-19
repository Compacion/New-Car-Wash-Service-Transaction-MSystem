# 📖 How to Use XAMPP Codespace

A comprehensive guide for students on using this cloud-based PHP development environment.

## Table of Contents

1. [Getting Started](#getting-started)
2. [Understanding the Environment](#understanding-the-environment)
3. [Creating Your First PHP Page](#creating-your-first-php-page)
4. [Working with MySQL Database](#working-with-mysql-database)
5. [Using phpMyAdmin](#using-phpmyadmin)
6. [Database Management](#database-management)
7. [File Management](#file-management)
8. [Working with Git](#working-with-git)
9. [Common Tasks](#common-tasks)
10. [Troubleshooting](#troubleshooting)

---

## Getting Started

### Opening Your Codespace

1. **Navigate to your repository** on GitHub
2. Click the green **"Code"** button
3. Select **"Codespaces"** tab
4. Click **"Create codespace on main"** (or open existing one)
5. Wait 2-3 minutes for initial setup (first time only)

### What Happens During Setup

The container automatically:
- ✅ Installs PHP 8.1 with Apache
- ✅ Starts MySQL 8.0 server
- ✅ Launches phpMyAdmin
- ✅ Creates the `students_db` database
- ✅ Installs VS Code extensions
- ✅ Configures all services to work together

### Verifying Everything Works

1. Click the **PORTS** tab at the bottom of VS Code
2. You should see ports **80**, **8080**, and **3306** listed
3. Click the globe icon (🌐) next to port **80** to open your web server
4. You should see the **Welcome page**
5. Click **"Run Health Check"** to verify all services

---

## Understanding the Environment

### Directory Structure

```
📁 Your Workspace
├── 📁 htdocs/              ← PUT YOUR PHP FILES HERE
│   ├── index.php           (Welcome page)
│   ├── info.php            (PHP configuration)
│   ├── health.php          (System check)
│   └── 📁 examples/        (Sample projects)
├── 📁 logs/                (Error logs)
├── 📁 backups/             (Database exports - created when needed)
└── 📁 .devcontainer/       (Container config - don't modify unless you know what you're doing)
```

### Where to Put Your Files

**IMPORTANT:** Always place your PHP files in the `htdocs/` folder!

```
✅ CORRECT: /workspaces/ICI-Github-XAMPP/htdocs/myproject.php
❌ WRONG:   /workspaces/ICI-Github-XAMPP/myproject.php
```

### Accessing Your Files

If you create `htdocs/test.php`, access it at:
```
https://your-codespace-url/test.php
```

---

## Creating Your First PHP Page

### Step 1: Create a New File

1. In VS Code, right-click the `htdocs` folder
2. Select **"New File"**
3. Name it `hello.php`

### Step 2: Add PHP Code

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My First PHP Page</title>
</head>
<body>
    <h1>Hello from PHP!</h1>
    <p>Current server time: <?php echo date('Y-m-d H:i:s'); ?></p>
    <p>PHP Version: <?php echo phpversion(); ?></p>
</body>
</html>
```

### Step 3: Save and View

1. Press `Ctrl+S` (Windows/Linux) or `Cmd+S` (Mac) to save
2. Go to the PORTS tab
3. Click the globe icon next to port 80
4. Add `/hello.php` to the URL in your browser

---

## Working with MySQL Database

### Database Information

- **Default Database:** `students_db` (already created)
- **Host:** `mysql` (when connecting from PHP)
- **Username:** `root`
- **Password:** `root`

### Connecting from PHP (Method 1: MySQLi)

```php
<?php
// Create connection
$conn = new mysqli('mysql', 'root', 'root', 'students_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";

// Close connection
$conn->close();
?>
```

### Connecting from PHP (Method 2: PDO)

```php
<?php
try {
    $pdo = new PDO('mysql:host=mysql;dbname=students_db', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
```

### Sample Query - Fetch Data

```php
<?php
$conn = new mysqli('mysql', 'root', 'root', 'students_db');

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Username: " . $row["username"] . "<br>";
        echo "Email: " . $row["email"] . "<br><br>";
    }
} else {
    echo "No results found";
}

$conn->close();
?>
```

### Sample Query - Insert Data

```php
<?php
$conn = new mysqli('mysql', 'root', 'root', 'students_db');

$username = "newstudent";
$email = "newstudent@example.com";
$fullName = "New Student";

$sql = "INSERT INTO users (username, email, full_name) 
        VALUES ('$username', '$email', '$fullName')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
```

---

## Using phpMyAdmin

### Accessing phpMyAdmin

1. Go to the **PORTS** tab in VS Code
2. Find port **8080**
3. Click the globe icon (🌐) to open phpMyAdmin
4. Login with:
   - **Username:** `root`
   - **Password:** `root`

### Common phpMyAdmin Tasks

#### Viewing Tables
1. Click **"students_db"** in the left sidebar
2. You'll see existing tables: `users`, `posts`
3. Click a table name to view its data

#### Running SQL Queries
1. Click the **"SQL"** tab at the top
2. Type your SQL query, for example:
```sql
SELECT * FROM users WHERE username = 'student1';
```
3. Click **"Go"** to execute

#### Creating a New Table
1. Click **"students_db"** database
2. Click the **"SQL"** tab
3. Paste your CREATE TABLE statement:
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
4. Click **"Go"**

#### Importing SQL File
1. Click **"students_db"** database
2. Click **"Import"** tab
3. Click **"Choose File"**
4. Select your `.sql` file
5. Click **"Go"** at the bottom

#### Exporting Database
1. Click **"students_db"** database
2. Click **"Export"** tab
3. Select **"Quick"** export method
4. Click **"Go"**
5. Save the downloaded `.sql` file

---

## Database Management

### Using the Built-in Scripts

These scripts are located in `.devcontainer/scripts/` and help you manage your database.

#### Export (Backup) Database

To create a backup of your database:

```bash
./.devcontainer/scripts/export-db.sh
```

This creates a file like: `backups/students_db_20250115_143022.sql`

#### Import (Restore) Database

To restore a database from a backup:

```bash
./.devcontainer/scripts/import-db.sh /workspace/backups/students_db_20250115_143022.sql
```

**Note:** This will overwrite existing data!

#### Reset Database

To reset the database to its initial state with sample data:

```bash
./.devcontainer/scripts/reset-db.sh
```

**Warning:** This deletes all your data and recreates the original tables!

### Manual Database Operations

#### Create a New Database

```bash
docker exec -i $(docker ps -q -f name=mysql) mysql -u root -proot -e "CREATE DATABASE my_new_db;"
```

#### Run SQL File

```bash
docker exec -i $(docker ps -q -f name=mysql) mysql -u root -proot students_db < /workspace/myfile.sql
```

---

## File Management

### Creating PHP Files

**Option 1: Using VS Code Interface**
1. Right-click `htdocs` folder
2. Click "New File"
3. Name your file with `.php` extension

**Option 2: Using Terminal**
```bash
touch /workspace/htdocs/newfile.php
```

### Organizing Your Project

Create subdirectories for better organization:

```
htdocs/
├── myproject/
│   ├── index.php
│   ├── login.php
│   ├── dashboard.php
│   └── includes/
│       ├── header.php
│       └── footer.php
```

Access: `https://your-codespace-url/myproject/index.php`

### File Permissions

If you encounter permission issues:

```bash
# Make htdocs writable
sudo chown -R www-data:www-data /workspace/htdocs

# Make a specific file writable
sudo chmod 666 /workspace/htdocs/uploads/somefile.txt
```

---

## Working with Git

### Committing Your Work

1. **Stage your changes:**
```bash
git add htdocs/
```

2. **Commit with a message:**
```bash
git commit -m "Added my PHP project"
```

3. **Push to GitHub:**
```bash
git push
```

### What Gets Committed?

The `.gitignore` file is configured to:

✅ **Include (tracked by git):**
- Your PHP files in `htdocs/`
- Container configuration files
- Sample projects

❌ **Exclude (not tracked):**
- Database data files (in Docker volumes)
- Log files
- Backup files (optional - you can track these if needed)
- Temporary files

### Important Git Notes

**Container files are tracked!** The `.devcontainer/` folder is part of your repository. This means:
- Other students can clone your repo and get the same environment
- You can pull updates without losing your container setup
- Everything "just works" when you clone to a new codespace

### Cloning Your Project to a New Codespace

1. Go to your repository on GitHub
2. Click "Code" → "Codespaces" → "Create codespace"
3. Wait for setup to complete
4. All your PHP files and database structure will be ready!

**Note:** Database **data** won't transfer (only the structure). Export your database first if you need the data!

---

## Common Tasks

### Starting/Stopping Services

#### Restart Apache
```bash
service apache2 restart
```

#### Check Apache Status
```bash
service apache2 status
```

#### View Running Containers
```bash
docker ps
```

### Viewing Logs

#### PHP Error Log
```bash
cat /workspace/logs/php-error.log

# Follow log in real-time
tail -f /workspace/logs/php-error.log
```

#### Apache Error Log
```bash
docker exec -i $(docker ps -q -f name=web) cat /var/log/apache2/error.log
```

#### MySQL Log
```bash
docker logs $(docker ps -q -f name=mysql)
```

### Testing PHP Configuration

Visit: `http://your-codespace-url/info.php`

Or run from terminal:
```bash
php -i | grep "Configuration File"
php -m  # List installed extensions
```

### Installing Additional PHP Extensions

If you need more extensions, edit `.devcontainer/Dockerfile`:

```dockerfile
RUN docker-php-ext-install extension_name
```

Then rebuild the container:
1. Press `F1` or `Ctrl+Shift+P`
2. Type "Rebuild Container"
3. Select "Dev Containers: Rebuild Container"

---

## Troubleshooting

### Problem: Services Not Running (Apache, MySQL, or phpMyAdmin)

If you experience issues with any of the services not responding, follow these steps to restart them:

#### Restarting Apache Web Server

If port 80 returns errors or pages don't load:

```bash
# Check if Apache is running
ps aux | grep apache2 | grep -v grep

# Start Apache if not running
service apache2 start

# Restart Apache to apply changes
service apache2 restart

# Check Apache status
service apache2 status
```

#### Restarting MySQL Database

If database connections fail or port 3306 is not accessible:

**Note:** MySQL runs in a separate Docker container, not in the web container.

```bash
# Test MySQL connection
mysql -h mysql -u root -proot --skip-ssl -e "SELECT VERSION();"

# If MySQL container is not responding, check container status
# MySQL should auto-restart due to restart policy in docker-compose.yml
```

#### Accessing phpMyAdmin

If port 8080 doesn't work:

1. **Check if phpMyAdmin container is running:**
   ```bash
   curl -I http://phpmyadmin
   ```

2. **If you see HTTP 200, phpMyAdmin is running** - The issue is with port forwarding:
   - Go to the **PORTS** tab in VS Code
   - Find port **8080**
   - Click the **globe icon** (🌐) to open phpMyAdmin in your browser
   - **Do not** try to access via `localhost:8080` from inside the container

3. **Login credentials:**
   - Username: `root`
   - Password: `root`

#### Quick Service Check

Run this command to see all running processes:

```bash
# Check Apache
ps aux | grep apache2 | grep -v grep

# Test MySQL connection
mysql -h mysql -u root -proot --skip-ssl -e "SELECT 1;"

# Test phpMyAdmin
curl -I http://phpmyadmin
```

#### Complete Service Restart Procedure

If multiple services are having issues:

```bash
# 1. Restart Apache
service apache2 restart

# 2. Verify Apache is serving files
curl -I http://localhost/

# 3. Test MySQL connection
mysql -h mysql -u root -proot --skip-ssl -e "SHOW DATABASES;"

# 4. Test phpMyAdmin
curl -s http://phpmyadmin/ | head -20
```

#### Using the Port Status Checker

Visit `http://your-codespace-url/test-ports.php` to see a visual status of all three services:
- ✅ Port 80 - Apache Web Server
- ✅ Port 3306 - MySQL Database  
- ✅ Port 8080 - phpMyAdmin

This page will show you exactly which services are working and which need attention.

### Problem: Port 80 not accessible

**Solution:**
1. Check if Apache is running: `service apache2 status`
2. Restart Apache: `service apache2 restart`
3. Check PORTS tab - make sure port 80 is forwarded

### Problem: Database connection failed

**Solution:**
1. Check if MySQL is running: `docker ps`
2. Test connection from terminal:
```bash
docker exec -i $(docker ps -q -f name=mysql) mysql -u root -proot -e "SELECT 1;"
```
3. Verify hostname is `mysql` not `localhost` in your PHP code

### Problem: Permission denied when writing files

**Solution:**
```bash
sudo chown -R www-data:www-data /workspace/htdocs
sudo chmod -R 755 /workspace/htdocs
```

### Problem: Changes not showing up

**Solution:**
1. Hard refresh your browser: `Ctrl+Shift+R` (Windows/Linux) or `Cmd+Shift+R` (Mac)
2. Clear browser cache
3. Check if you saved the file (`Ctrl+S`)
4. Verify you're editing the correct file in `htdocs/`

### Problem: SQL syntax error

**Common mistakes:**
- Missing quotes around strings: `'value'`
- Forgetting semicolon at end of query
- Reserved keywords (use backticks): `` `order` ``
- Table/column doesn't exist (check spelling)

**Debug with:**
```php
if (!$result) {
    echo "Error: " . $conn->error;
}
```

### Problem: Session not persisting

**Solution:**
Make sure you call `session_start()` at the beginning of every page that uses sessions:
```php
<?php
session_start();
// ... rest of your code
?>
```

### Problem: Codespace is slow

**Solutions:**
- Close unused tabs and extensions
- Stop any background processes you don't need
- Delete old log files: `rm /workspace/logs/*.log`
- Consider using a machine with more resources

### Problem: "Out of memory" error

**Solution:**
Edit `.devcontainer/php.ini`:
```ini
memory_limit = 512M  ; Increase from 256M
```
Then rebuild the container.

---

## Additional Resources

### Sample Projects

Explore `/htdocs/examples/` for working examples:
1. Database Connection
2. CRUD Operations
3. Form Handling  
4. Session Management

### Useful PHP Functions

**String Functions:**
- `strlen()` - Get string length
- `trim()` - Remove whitespace
- `strtolower()` / `strtoupper()` - Change case
- `substr()` - Get part of string
- `str_replace()` - Replace text

**Array Functions:**
- `count()` - Get array length
- `array_push()` - Add item to end
- `in_array()` - Check if value exists
- `implode()` / `explode()` - Join/split arrays

**Database Functions (MySQLi):**
- `mysqli_connect()` - Connect to database
- `mysqli_query()` - Execute query
- `mysqli_fetch_assoc()` - Get result row
- `mysqli_real_escape_string()` - Escape special characters

**Security Functions:**
- `htmlspecialchars()` - Prevent XSS
- `password_hash()` - Hash passwords
- `password_verify()` - Verify hashed passwords
- `filter_var()` - Validate/sanitize input

### Quick SQL Reference

**SELECT:**
```sql
SELECT * FROM users WHERE id = 1;
SELECT username, email FROM users WHERE age > 18;
```

**INSERT:**
```sql
INSERT INTO users (username, email) VALUES ('john', 'john@example.com');
```

**UPDATE:**
```sql
UPDATE users SET email = 'newemail@example.com' WHERE id = 1;
```

**DELETE:**
```sql
DELETE FROM users WHERE id = 1;
```

**JOIN:**
```sql
SELECT users.username, posts.title 
FROM users 
JOIN posts ON users.id = posts.user_id;
```

---

## Tips for Success

1. **Always test your code** - Use the health check and error logs
2. **Save often** - Press `Ctrl+S` frequently
3. **Commit regularly** - Don't lose your work!
4. **Read error messages** - They tell you what's wrong
5. **Use the examples** - Learn from working code
6. **Ask for help** - Share your codespace URL with instructors
7. **Backup your database** - Export before making big changes
8. **Comment your code** - Future you will thank you!

---

## Need Help?

- Check `/htdocs/health.php` for system status
- View error logs in `/workspace/logs/`
- Review example code in `/htdocs/examples/`
- Consult the main [README.md](README.md)

---

**Happy Coding! 🎉**
