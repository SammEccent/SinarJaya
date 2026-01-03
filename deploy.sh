#!/bin/bash
# ================================================
# QUICK DEPLOYMENT SCRIPT
# ================================================
# This script helps with production deployment
# Run: bash deploy.sh
# ================================================

echo "================================================"
echo "SINAR JAYA - Production Deployment Script"
echo "================================================"
echo ""

# Check if running as root
if [ "$EUID" -eq 0 ]; then 
    echo "⚠️  Warning: Running as root. Please run as normal user."
    exit 1
fi

# Step 1: Backup
echo "📦 Step 1: Creating backup..."
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="backups"
mkdir -p $BACKUP_DIR

if [ -f "app/config/config.php" ]; then
    cp app/config/config.php "$BACKUP_DIR/config_backup_$TIMESTAMP.php"
    echo "✅ Config backed up"
fi

# Step 2: Update files
echo ""
echo "📝 Step 2: Updating configuration files..."

# Copy production htaccess files
if [ -f ".htaccess.production" ]; then
    cp .htaccess.production .htaccess
    echo "✅ Root .htaccess updated"
fi

if [ -f "public/.htaccess.production" ]; then
    cp public/.htaccess.production public/.htaccess
    echo "✅ Public .htaccess updated"
fi

if [ -f "app/.htaccess.production" ]; then
    cp app/.htaccess.production app/.htaccess
    echo "✅ App .htaccess updated"
fi

# Step 3: Set permissions
echo ""
echo "🔐 Step 3: Setting file permissions..."

# Set directory permissions
find . -type d -exec chmod 755 {} \; 2>/dev/null
echo "✅ Directory permissions set (755)"

# Set file permissions
find . -type f -exec chmod 644 {} \; 2>/dev/null
echo "✅ File permissions set (644)"

# Writable directories
chmod 755 public/uploads/ 2>/dev/null
chmod 755 public/uploads/payments/ 2>/dev/null
chmod 755 public/uploads/tickets/ 2>/dev/null
mkdir -p logs
chmod 755 logs/ 2>/dev/null
echo "✅ Upload and log directories writable"

# Protect sensitive files
if [ -f "app/config/config.php" ]; then
    chmod 600 app/config/config.php
    echo "✅ Config file protected (600)"
fi

# Step 4: Composer
echo ""
echo "📦 Step 4: Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --no-dev --optimize-autoloader
    echo "✅ Composer dependencies installed"
else
    echo "⚠️  Composer not found. Please install manually."
fi

# Step 5: Cleanup
echo ""
echo "🧹 Step 5: Cleanup..."

# Remove development files
rm -f .htaccess.production
rm -f public/.htaccess.production
rm -f app/.htaccess.production
rm -f app/config/config.production.php
echo "✅ Cleanup completed"

# Final checklist
echo ""
echo "================================================"
echo "✅ Deployment completed!"
echo "================================================"
echo ""
echo "📋 IMPORTANT: Complete these manual steps:"
echo ""
echo "1. ⚠️  Update app/config/config.php with production values:"
echo "   - BASEURL"
echo "   - Database credentials"
echo "   - Email credentials"
echo "   - Set ENVIRONMENT='production'"
echo ""
echo "2. 🔒 Install SSL certificate and enable HTTPS redirect"
echo ""
echo "3. 🗄️  Import database: mysql -u user -p dbname < sinarjaya_db.sql"
echo ""
echo "4. 🔑 Change default admin password"
echo ""
echo "5. 📧 Test email sending"
echo ""
echo "6. 🧪 Test all functionality"
echo ""
echo "7. 📊 Set up monitoring and backups"
echo ""
echo "For complete checklist, see DEPLOYMENT.md"
echo "================================================"
