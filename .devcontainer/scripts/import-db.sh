#!/bin/bash
# Import Database Script
# Usage: ./.devcontainer/scripts/import-db.sh <sql_file> [database_name]

set -e

SQL_FILE=$1
DATABASE=${2:-students_db}

if [ -z "$SQL_FILE" ]; then
    echo "Error: No SQL file specified"
    echo "Usage: $0 <sql_file> [database_name]"
    echo ""
    echo "Example: $0 /workspace/backups/students_db_20250115_120000.sql"
    exit 1
fi

if [ ! -f "$SQL_FILE" ]; then
    echo "Error: File '$SQL_FILE' not found"
    exit 1
fi

echo "======================================"
echo "Database Import Tool"
echo "======================================"
echo "SQL File: $SQL_FILE"
echo "Database: $DATABASE"
echo ""
echo "WARNING: This will overwrite existing data in the database!"
read -p "Continue? (y/N): " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Import cancelled."
    exit 0
fi

echo "Importing database..."
docker exec -i $(docker-compose -f /workspace/.devcontainer/docker-compose.yml ps -q mysql) \
    mysql -u root -proot "$DATABASE" < "$SQL_FILE"

if [ $? -eq 0 ]; then
    echo "✓ Database imported successfully!"
else
    echo "✗ Import failed!"
    exit 1
fi
