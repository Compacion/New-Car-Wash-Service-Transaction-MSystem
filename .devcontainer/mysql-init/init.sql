-- Initialize Database for Students
-- This script runs automatically when the container is first created

-- Create the students database (already created by environment variable, but ensuring it exists)
CREATE DATABASE IF NOT EXISTS students_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE students_db;

-- Create a sample users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create a sample posts table
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    content TEXT,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO users (username, email, full_name) VALUES
('student1', 'student1@example.com', 'First Student'),
('student2', 'student2@example.com', 'Second Student'),
('admin', 'admin@example.com', 'Administrator');

INSERT INTO posts (user_id, title, content, status) VALUES
(1, 'Welcome to PHP & MySQL', 'This is a sample post created for demonstration purposes.', 'published'),
(1, 'Learning Database Basics', 'SQL is essential for web development.', 'published'),
(2, 'My First Draft', 'This post is still being written.', 'draft');

-- Grant necessary privileges (already root, but good practice)
FLUSH PRIVILEGES;
