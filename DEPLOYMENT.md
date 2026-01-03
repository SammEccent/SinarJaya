# ================================================

# DEPLOYMENT CHECKLIST - SINAR JAYA BUS SYSTEM

# ================================================

# Follow these steps before deploying to production

# ================================================

## PRE-DEPLOYMENT CHECKLIST

### 1. CONFIGURATION FILES

- [ ] Copy `config.production.php` to `config.php`
- [ ] Update BASEURL to your production domain
- [ ] Change ENVIRONMENT to 'production'
- [ ] Update database credentials (DB_HOST, DB_NAME, DB_USER, DB_PASS)
- [ ] Update email credentials (MAIL_USERNAME, MAIL_PASSWORD)
- [ ] Update MAIL_FROM_ADDRESS with your domain email

### 2. SECURITY FILES

- [ ] Rename `.htaccess.production` to `.htaccess` (root folder)
- [ ] Rename `public/.htaccess.production` to `public/.htaccess`
- [ ] Rename `app/.htaccess.production` to `app/.htaccess`
- [ ] Verify `public/uploads/.htaccess` exists and blocks PHP execution
- [ ] Create `logs/` directory with write permissions (755)
- [ ] Set proper file permissions (see section below)

### 3. DATABASE SETUP

- [ ] Create production database
- [ ] Import `sinarjaya_db.sql`
- [ ] Create database user with appropriate privileges
- [ ] Update admin credentials
- [ ] Test database connection

### 4. FILE PERMISSIONS (Linux/Unix hosting)

```bash
# Set directory permissions
find . -type d -exec chmod 755 {} \;

# Set file permissions
find . -type f -exec chmod 644 {} \;

# Make uploads writable
chmod 755 public/uploads/
chmod 755 public/uploads/payments/
chmod 755 public/uploads/tickets/

# Make logs writable
chmod 755 logs/

# Protect sensitive files
chmod 600 app/config/config.php
```

### 5. COMPOSER DEPENDENCIES

```bash
# Install production dependencies only (no dev packages)
composer install --no-dev --optimize-autoloader
```

### 6. SSL CERTIFICATE

- [ ] Install SSL certificate (Let's Encrypt recommended)
- [ ] Uncomment HTTPS redirect in `.htaccess`
- [ ] Update SESSION_COOKIE_SECURE to true in config.php
- [ ] Test HTTPS connection

### 7. EMAIL CONFIGURATION

- [ ] Test email sending functionality
- [ ] Verify SPF, DKIM, DMARC records (if using custom domain)
- [ ] Test verification emails
- [ ] Test payment notification emails

### 8. PERFORMANCE OPTIMIZATION

- [ ] Enable OPcache in PHP
- [ ] Enable compression (gzip/deflate)
- [ ] Configure browser caching
- [ ] Optimize images
- [ ] Enable CDN (optional)

### 9. SECURITY HARDENING

- [ ] Disable PHP error display
- [ ] Enable error logging
- [ ] Remove development files (.git, tests/, etc.)
- [ ] Implement rate limiting (future)
- [ ] Set up firewall rules
- [ ] Disable unused PHP functions
- [ ] Review file permissions

### 10. MONITORING & LOGGING

- [ ] Set up error log monitoring
- [ ] Configure backup schedule
- [ ] Set up uptime monitoring
- [ ] Create database backup script
- [ ] Test restore procedure

### 11. TESTING

- [ ] Test user registration and login
- [ ] Test booking flow end-to-end
- [ ] Test payment upload
- [ ] Test email notifications
- [ ] Test admin panel functions
- [ ] Test on mobile devices
- [ ] Test different browsers

### 12. CLEANUP

- [ ] Remove test data from database
- [ ] Delete development configuration files
- [ ] Remove documentation files (optional)
- [ ] Clear any cached files

## IMPORTANT SECURITY NOTES

### Files to NEVER commit to version control:

- app/config/config.php (contains sensitive credentials)
- .env files
- Upload directories with actual files
- Log files

### Default Admin Account

**CRITICAL:** Change default admin password immediately after deployment!

```sql
-- Update admin password
UPDATE users SET password = ? WHERE role = 'admin' AND id = 1;
```

### Required PHP Extensions

- PDO
- PDO_MySQL
- OpenSSL
- MBString
- JSON
- GD or ImageMagick

### Recommended PHP Settings (php.ini)

```ini
display_errors = Off
log_errors = On
error_log = /path/to/logs/php-error.log
upload_max_filesize = 2M
post_max_size = 2M
max_execution_time = 30
memory_limit = 128M
session.cookie_secure = On
session.cookie_httponly = On
session.cookie_samesite = Strict
```

## HOSTING REQUIREMENTS

### Minimum Requirements:

- PHP 7.4 or higher (8.0+ recommended)
- MySQL 5.7 or higher (8.0+ recommended)
- Apache 2.4 or Nginx
- SSL Certificate
- 500MB disk space minimum
- SMTP access for emails

### Recommended Hosting Providers (Indonesia):

- Niagahoster
- Hostinger
- Dewaweb
- IDCloudhost
- Rumahweb

## POST-DEPLOYMENT

### Immediate Actions:

1. Change all default passwords
2. Test critical functionality
3. Monitor error logs for first 24 hours
4. Set up automated backups
5. Create admin user guide

### Regular Maintenance:

- Daily: Check error logs
- Weekly: Database backup
- Monthly: Security updates
- Quarterly: Performance review

## ROLLBACK PLAN

If issues occur after deployment:

1. Keep previous version files as backup
2. Keep database backup before deployment
3. Document rollback procedure
4. Test rollback in staging first

## SUPPORT CONTACTS

- Database issues: Check logs/error.log
- Email issues: Verify SMTP credentials
- Payment issues: Check payment proof uploads
- Performance issues: Check server resources

## VERSION CONTROL

Current Version: 1.0.0
Deployment Date: [FILL IN]
Deployed By: [FILL IN]
Server: [FILL IN]

---

Last Updated: January 2026
