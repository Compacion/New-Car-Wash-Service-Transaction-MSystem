#!/bin/bash
# Reset Database Script
# Usage: ./.devcontainer/scripts/reset-db.sh [database_name]

set -e

DATABASE=${1:-students_db}

echo "======================================"
echo "Database Reset Tool"
echo "======================================"
echo "Database: $DATABASE"
echo ""
echo "WARNING: This will DROP and recreate the database!"
echo "All data in '$DATABASE' will be PERMANENTLY DELETED!"
read -p "Continue? (y/N): " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Reset cancelled."
    exit 0
fi

echo "Dropping database..."
docker exec -i $(docker-compose -f /workspace/.devcontainer/docker-compose.yml ps -q mysql) \
    mysql -u root -proot -e "DROP DATABASE IF EXISTS $DATABASE;"

echo "Creating database..."
docker exec -i $(docker-compose -f /workspace/.devcontainer/docker-compose.yml ps -q mysql) \
    mysql -u root -proot -e "CREATE DATABASE $DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

echo "Running initialization script..."
docker exec -i $(docker-compose -f /workspace/.devcontainer/docker-compose.yml ps -q mysql) \
    mysql -u root -proot "$DATABASE" < /workspace/.devcontainer/mysql-init/init.sql

if [ $? -eq 0 ]; then
    echo "✓ Database reset successfully!"
    echo "The database has been restored to its initial state with sample data."
else
    echo "✗ Reset failed!"
    exit 1
fi
