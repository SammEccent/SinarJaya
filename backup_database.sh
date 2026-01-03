#!/bin/bash
# ================================================
# DATABASE BACKUP SCRIPT
# Automated backup for Sinar Jaya Database
# ================================================

# Configuration
DB_USER="your_db_user"
DB_PASS="your_db_password"
DB_NAME="sinarjaya_db"
DB_HOST="localhost"

# Backup directory
BACKUP_DIR="/path/to/backups"
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="$BACKUP_DIR/sinarjaya_backup_$DATE.sql"

# Create backup directory if not exists
mkdir -p $BACKUP_DIR

# Dump database
mysqldump -h $DB_HOST -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_FILE

# Compress backup
gzip $BACKUP_FILE

# Delete backups older than 30 days
find $BACKUP_DIR -name "sinarjaya_backup_*.sql.gz" -mtime +30 -delete

echo "Backup completed: $BACKUP_FILE.gz"

# Optional: Upload to cloud storage
# aws s3 cp $BACKUP_FILE.gz s3://your-bucket/backups/
