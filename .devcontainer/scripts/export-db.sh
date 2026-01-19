#!/bin/bash
# Export Database Script
# Usage: ./.devcontainer/scripts/export-db.sh [database_name]

set -e

DATABASE=${1:-students_db}
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
EXPORT_DIR="/workspace/backups"
EXPORT_FILE="${EXPORT_DIR}/${DATABASE}_${TIMESTAMP}.sql"

# Create backups directory if it doesn't exist
mkdir -p "$EXPORT_DIR"

echo "======================================"
echo "Database Export Tool"
echo "======================================"
echo "Database: $DATABASE"
echo "Export file: $EXPORT_FILE"
echo ""

# Export database
echo "Exporting database..."
docker exec -i $(docker-compose -f /workspace/.devcontainer/docker-compose.yml ps -q mysql) \
    mysqldump -u root -proot "$DATABASE" > "$EXPORT_FILE"

if [ $? -eq 0 ]; then
    echo "✓ Database exported successfully!"
    echo "Location: $EXPORT_FILE"
    echo "File size: $(du -h "$EXPORT_FILE" | cut -f1)"
else
    echo "✗ Export failed!"
    exit 1
fi

echo ""
echo "To import this backup later, run:"
echo "./.devcontainer/scripts/import-db.sh $EXPORT_FILE"
