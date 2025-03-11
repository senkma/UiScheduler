# UiScheduler Module

Universal module for switching schedulers and mutexes

## Features
- Schedule crons/jobs using Crunz or Laravel Scheduler.
- Mutex File or Redis

## Sources
Laravel scheduler
- https://laravel.com/docs/9.x/scheduling

Crunz scheduler
- https://github.com/crunzphp/crunz

## Work Process
1. UiScheduler
```bash
php artisan uischeduler:run
```
2. Laravel scheduler
```bash
php artisan module:list
```
3. CrunzPHP scheduler
```bash
vendor/bin/crunz schedule:list
```
4. Change scheduler, mutex - In .env set
```bash
#UiScheduler
UISCHEDULER_SCHEDULER=laravel #laravel, crunz
UISCHEDULER_MUTEX=redis #file, redis
```
5. Set new jobs in app/Jobs
6. Configure cron/jobs in config/uischeduler_config.php
7. Check logs in- /storage/logs/laravel.log

## Installation
1. Prerequisites / Make new from scratch:
```bash
cd /var/www/html
sudo composer create-project laravel/laravel=9 uischeduler
cd uischeduler/
composer update
composer require nwidart/laravel-modules="9.*"
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
php artisan module:make UiScheduler
```

edit composer.json
```bash
    "autoload": {
       "psr-4": {
           "App\\": "app/",
           "Modules\\": "Modules/",
```
```bash
composer dump-autoload

composer require crunzphp/crunz
vendor/bin/crunz publish:config
```

2. Install module:
```bash
cd /var/www/html/uischeduler/Modules
copy module
```
- do everything you need from prerequisites

3. Redis Install
```bash
sudo apt update
sudo apt install redis-server
sudo nano /etc/redis/redis.conf
sudo systemctl restart redis.service
sudo apt install php-redis
composer require predis/predis
```

## Configuration
1. Crontab
```bash
crontab -e
crontab -l
```
2. Configure .env
- database (mysql)
- cachedriver
- uischeduler
3. edit config/app.php:
- add to providers
```php
 Modules\UiScheduler\Providers\UiSchedulerServiceProvider::class,
 ```
4. publish job config
```bash
php artisan vendor:publish --provider="Modules\UiScheduler\Providers\UiSchedulerServiceProvider" --tag="config"
bash
5. add or change in .env
```bash
#UiScheduler
UISCHEDULER_SCHEDULER=laravel #laravel, crunz
UISCHEDULER_MUTEX=redis #file, redis
UISCHEDULER_REDIS_SCHEME=tcp
UISCHEDULER_REDIS_HOST=127.0.0.1
UISCHEDULER_REDIS_PORT=6379
```
        
## Debug
1. Clear and reset all
```bash
- php artisan config:clear
- php artisan cache:clear

    composer dump-autoload
```
2. Redis
```bash
    php artisan tinker
    redis-cli
    KEYS *
```
3. Crontab
```bash
    grep CRON /var/log/syslog
```
4. CrunzPHP
```bash
    vendor/bin/crunz schedule:run
    vendor/bin/crunz schedule:list
```

## Known problems
1. Timezone
```bash
    cat /etc/timezone
    php -i | grep timezone
```

## Server installation
1. Prerequisites
- Ubuntu
2. Install Apache, PHP, MYSQL
```bash
    sudo apt update
    sudo apt install unzip curl software-properties-common
    sudo apt install apache2
    sudo systemctl status apache2
    sudo systemctl enable apache2
    sudo apt install php
    php -v
    sudo apt install php-mbstring php-mysql php-curl php-cli php-dev php-imagick php-soap php-zip php-xml php-imap php-xmlrpc php-gd php-opcache php-intl
    sudo apt install mariadb-server
    sudo mysql -u root -p
```
3. Install Composer
```bash
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    sudo chmod +x /usr/local/bin/composer
    composer --version
    composer
    cd /var/www/html
```