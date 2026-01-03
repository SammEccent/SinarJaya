# ================================================

# SERVER REQUIREMENTS & CONFIGURATION

# ================================================

## Minimum Server Requirements

### PHP Requirements:

- **Version**: PHP 7.4 or higher (8.0+ recommended)
- **Memory Limit**: 128MB minimum (256MB recommended)
- **Max Execution Time**: 30 seconds
- **Upload Max Size**: 2MB minimum

### Required PHP Extensions:

```
✓ pdo
✓ pdo_mysql
✓ mysqli
✓ mbstring
✓ openssl
✓ json
✓ curl
✓ gd or imagick (for image processing)
✓ zip
✓ xml
✓ fileinfo
```

### MySQL Requirements:

- **Version**: MySQL 5.7+ or MariaDB 10.2+
- **Recommended**: MySQL 8.0+
- **InnoDB Engine**: Required
- **Character Set**: utf8mb4
- **Collation**: utf8mb4_unicode_ci

### Web Server:

- **Apache**: 2.4+ with mod_rewrite enabled
- **OR Nginx**: 1.18+
- **SSL Certificate**: Required for production

## Recommended PHP.ini Settings

```ini
# Error Handling (Production)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
error_log = /path/to/logs/php_errors.log

# File Uploads
file_uploads = On
upload_max_filesize = 2M
max_file_uploads = 10
post_max_size = 2M

# Execution & Memory
max_execution_time = 30
max_input_time = 30
memory_limit = 128M

# Session Security
session.cookie_httponly = 1
session.cookie_secure = 1
session.cookie_samesite = Strict
session.gc_maxlifetime = 7200
session.use_strict_mode = 1

# Security
expose_php = Off
allow_url_fopen = On
allow_url_include = Off
enable_dl = Off

# Date & Time
date.timezone = Asia/Jakarta
```

## Apache Configuration

### Enable Required Modules:

```bash
sudo a2enmod rewrite
sudo a2enmod headers
sudo a2enmod expires
sudo a2enmod deflate
sudo a2enmod ssl
sudo systemctl restart apache2
```

### Virtual Host Example:

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/sinarjaya/public

    <Directory /var/www/sinarjaya/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Redirect to HTTPS
    RewriteEngine On
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</VirtualHost>

<VirtualHost *:443>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    DocumentRoot /var/www/sinarjaya/public

    SSLEngine on
    SSLCertificateFile /path/to/certificate.crt
    SSLCertificateKeyFile /path/to/private.key
    SSLCertificateChainFile /path/to/chain.crt

    <Directory /var/www/sinarjaya/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Security Headers
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set X-Content-Type-Options "nosniff"
    Header always set Referrer-Policy "strict-origin-when-cross-origin"

    ErrorLog ${APACHE_LOG_DIR}/sinarjaya_error.log
    CustomLog ${APACHE_LOG_DIR}/sinarjaya_access.log combined
</VirtualHost>
```

## Nginx Configuration (Alternative)

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    root /var/www/sinarjaya/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    # PHP-FPM Configuration
    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # URL Rewriting
    location / {
        try_files $uri $uri/ /index.php?url=$uri&$args;
    }

    # Block access to sensitive files
    location ~ /\. {
        deny all;
    }

    location ~ \.(htaccess|htpasswd|ini|log|sql)$ {
        deny all;
    }

    # Static file caching
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

## MySQL Configuration

### Create Database & User:

```sql
-- Create database
CREATE DATABASE sinarjaya_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'sinarjaya_user'@'localhost' IDENTIFIED BY 'strong_password_here';

-- Grant privileges
GRANT SELECT, INSERT, UPDATE, DELETE ON sinarjaya_db.* TO 'sinarjaya_user'@'localhost';
FLUSH PRIVILEGES;

-- Import database
USE sinarjaya_db;
SOURCE /path/to/sinarjaya_db.sql;
```

### Recommended my.cnf Settings:

```ini
[mysqld]
max_connections = 100
innodb_buffer_pool_size = 256M
innodb_log_file_size = 64M
query_cache_size = 32M
query_cache_type = 1
```

## Cron Jobs (Automated Tasks)

### Database Backup (Daily at 2 AM):

```bash
0 2 * * * /path/to/SinarJaya/backup_database.sh >> /var/log/sinarjaya_backup.log 2>&1
```

### Clean Expired Bookings (Every hour):

```bash
0 * * * * /usr/bin/php /path/to/SinarJaya/app/cron/expire_bookings.php
```

### Log Rotation:

```bash
0 0 * * 0 /path/to/SinarJaya/app/cron/rotate_logs.sh
```

## Firewall Rules

### UFW (Ubuntu):

```bash
# Allow SSH
sudo ufw allow 22/tcp

# Allow HTTP/HTTPS
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp

# Enable firewall
sudo ufw enable
```

## Performance Optimization

### Enable OPcache (php.ini):

```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

### Enable Compression (Apache):

```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript application/json
</IfModule>
```

## Monitoring & Logging

### Log Files Locations:

- PHP Errors: `/var/log/php_errors.log`
- Apache Access: `/var/log/apache2/access.log`
- Apache Errors: `/var/log/apache2/error.log`
- Application: `/path/to/SinarJaya/logs/error.log`

### Recommended Monitoring Tools:

- **Uptime**: UptimeRobot, Pingdom
- **Errors**: Sentry, Rollbar
- **Performance**: New Relic, DataDog
- **Server**: Nagios, Zabbix

## SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt-get update
sudo apt-get install certbot python3-certbot-apache

# Get certificate
sudo certbot --apache -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (already configured by certbot)
sudo certbot renew --dry-run
```

## Troubleshooting

### Issue: 500 Internal Server Error

**Check**:

- Apache error logs
- File permissions
- .htaccess syntax
- PHP errors

### Issue: Database Connection Failed

**Check**:

- MySQL service status
- Database credentials in config.php
- User privileges
- Firewall rules

### Issue: Upload Directory Not Writable

**Solution**:

```bash
sudo chown -R www-data:www-data /path/to/uploads
sudo chmod -R 755 /path/to/uploads
```

## Security Checklist

- [ ] SSL certificate installed and working
- [ ] HTTPS redirect enabled
- [ ] Strong database passwords
- [ ] File permissions properly set
- [ ] PHP display_errors disabled
- [ ] Sensitive files protected by .htaccess
- [ ] Regular security updates applied
- [ ] Firewall configured
- [ ] Backup system in place
- [ ] Monitoring enabled

---

**For support**: support@sinarjaya.com
