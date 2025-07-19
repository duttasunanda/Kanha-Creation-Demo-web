# 🚀 Deployment Guide - Nilkamal Furniture Platform

## 📋 Pre-Deployment Checklist

### ✅ Code Preparation
- [ ] All PHP errors resolved
- [ ] Database migrations tested
- [ ] Environment variables configured
- [ ] Assets compiled for production
- [ ] Security headers implemented
- [ ] Error logging configured

### ✅ Server Requirements
- [ ] PHP 8.1 or higher
- [ ] Web server (Apache/Nginx)
- [ ] MySQL/PostgreSQL database
- [ ] SSL certificate installed
- [ ] Domain name configured

## 🌐 Production Deployment

### 1. Environment Setup

Create production `.env` file:

```env
# Application
APP_NAME="Nilkamal Furniture"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
APP_KEY=base64:your-app-key-here

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=furniture_production
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password

# File Storage
FILESYSTEM_DISK=public

# Session & Cache
SESSION_DRIVER=file
CACHE_DRIVER=file

# Security
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

### 2. File Permissions

Set correct permissions:

```bash
# Make storage and cache writable
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Set ownership (replace 'www-data' with your web server user)
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

### 3. Web Server Configuration

#### Apache Configuration

Create `.htaccess` in project root:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

#### Nginx Configuration

Add to nginx site config:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/project/public;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    
    location ~ /\.ht {
        deny all;
    }
}
```

### 4. SSL Configuration

#### Free SSL with Let's Encrypt

```bash
# Install certbot
sudo apt install certbot python3-certbot-nginx

# Get certificate
sudo certbot --nginx -d yourdomain.com

# Auto-renewal (add to crontab)
0 12 * * * /usr/bin/certbot renew --quiet
```

## 📊 Database Setup

### 1. Create Production Database

```sql
-- Connect to MySQL
mysql -u root -p

-- Create database
CREATE DATABASE furniture_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user
CREATE USER 'furniture_user'@'localhost' IDENTIFIED BY 'secure_password_here';

-- Grant permissions
GRANT ALL PRIVILEGES ON furniture_production.* TO 'furniture_user'@'localhost';
FLUSH PRIVILEGES;
```

### 2. Run Migrations

```bash
# Run migrations
php artisan migrate --force

# Seed initial data
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=CategorySeeder
```

## 🔐 Security Hardening

### 1. Environment Security

```php
// config/app.php - Ensure debug is false
'debug' => env('APP_DEBUG', false),

// Hide server information
header_remove('X-Powered-By');
```

### 2. File Security

Remove sensitive files from public access:

```bash
# Remove development files
rm composer-setup.php
rm README.md
rm .env.example

# Secure sensitive directories
chmod 600 .env
chmod -R 644 config/
```

### 3. Database Security

```sql
-- Remove test accounts
DELETE FROM users WHERE email LIKE '%test%';

-- Update admin password
UPDATE users SET password = 'hashed_secure_password' WHERE role = 'admin';
```

## 📈 Performance Optimization

### 1. Caching

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### 2. Asset Optimization

```bash
# Compile assets for production
npm run build

# Optimize images
# Use tools like TinyPNG for product images
```

### 3. Server Optimization

#### PHP Configuration (`php.ini`)

```ini
# Memory and execution
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 10M
post_max_size = 10M

# OPcache (recommended)
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
```

## 🎯 Domain & DNS Setup

### 1. Domain Configuration

Point domain to your server:

```
# DNS Records
A     yourdomain.com       your.server.ip.address
CNAME www                  yourdomain.com
```

### 2. Subdomain Setup (Optional)

```
# For admin panel
CNAME admin               yourdomain.com
```

## 📊 Monitoring & Logging

### 1. Error Logging

```php
// config/logging.php
'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => 'error',
        'days' => 14,
    ],
],
```

### 2. Performance Monitoring

```bash
# Monitor server resources
htop
iotop
df -h

# Check application logs
tail -f storage/logs/laravel.log
```

## 🔄 Backup Strategy

### 1. Database Backup

```bash
#!/bin/bash
# backup-db.sh
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u furniture_user -p furniture_production > /backups/db_$DATE.sql
gzip /backups/db_$DATE.sql

# Keep only last 30 days
find /backups -name "db_*.sql.gz" -mtime +30 -delete
```

### 2. File Backup

```bash
#!/bin/bash
# backup-files.sh
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf /backups/files_$DATE.tar.gz /path/to/project/storage/app/public/
```

### 3. Automated Backups

Add to crontab:

```bash
# Daily database backup at 2 AM
0 2 * * * /path/to/backup-db.sh

# Weekly file backup on Sunday at 3 AM
0 3 * * 0 /path/to/backup-files.sh
```

## 🚀 Going Live Checklist

### Final Pre-Launch Steps

1. **Test all functionality**
   - [ ] Homepage loads correctly
   - [ ] Product pages work
   - [ ] Cart functionality
   - [ ] Checkout process
   - [ ] Admin panel access

2. **Security verification**
   - [ ] HTTPS working
   - [ ] Admin passwords changed
   - [ ] Debug mode disabled
   - [ ] Sensitive files secured

3. **Performance check**
   - [ ] Page load times < 3 seconds
   - [ ] Images optimized
   - [ ] Caching enabled

4. **SEO basics**
   - [ ] Meta titles and descriptions
   - [ ] Sitemap generated
   - [ ] Google Analytics installed

### Launch Day

```bash
# Final deployment commands
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear any development cache
php artisan cache:clear
```

## 🛠️ Post-Launch Maintenance

### Daily Tasks
- Monitor error logs
- Check website uptime
- Review performance metrics

### Weekly Tasks
- Update product inventory
- Review user feedback
- Check security logs
- Backup verification

### Monthly Tasks
- Server updates
- Security patches
- Performance optimization
- Content updates

---

**Congratulations! Your Nilkamal Furniture platform is now live! 🎉**

For ongoing support and updates, refer to the development documentation and maintain regular backups.
