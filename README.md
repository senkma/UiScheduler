# UiScheduler Module

Universal module for switching schedulers and mutexes

## Features
- Schedule crons/jobs using Crunz or Laravel Scheduler.
- Mutex File or Redis

## Sources
Laravel scheduler
    https://laravel.com/docs/9.x/scheduling
Crunz scheduler
    https://github.com/crunzphp/crunz

## Work Process
1. UiScheduler
    php artisan uischeduler:run
2. Laravel scheduler
    php artisan module:list
3. CrunzPHP scheduler
    vendor/bin/crunz schedule:list
4. Change scheduler, mutex
    In .env set
    UISCHEDULER_SCHEDULER=laravel #laravel, crunz
    CACHE_DRIVER=redis #file, redis
5. Set new jobs
    app/Jobs
5. Configure cron/jobs
    config/uischeduler_config.php
6. Check logs
    /storage/logs/laravel.log

## Installation
1. Prerequisites / Make new from scratch:
    cd /var/www/html
    sudo composer create-project laravel/laravel=9 uischeduler
    cd uischeduler/
    composer update
    composer require nwidart/laravel-modules="9.*"
    php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
    php artisan module:make UiScheduler
    edit composer.json
           "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Modules\\": "Modules/",
    composer dump-autoload

    composer require crunzphp/crunz
    vendor/bin/crunz publish:config

2. Install module:
    cd /var/www/html/uischeduler/Modules
    copy module
    do everything you need from prerequisites

3. Redis Install
    sudo apt update
    sudo apt install redis-server
    sudo nano /etc/redis/redis.conf
    sudo systemctl restart redis.service
    sudo apt install php-redis
    composer require predis/predis

## Configuration
1. Crontab
    crontab -e
    crontab -l
2. Configure .env
    database (mysql)
    cachedriver
    uischeduler
3. edit config/app.php:
    add to providers
    Modules\UiScheduler\Providers\UiSchedulerServiceProvider::class,
4. publish job config
    php artisan vendor:publish --provider="Modules\UiScheduler\Providers\UiSchedulerServiceProvider" --tag="config"
5. add or change in .env
    #UiScheduler
    UISCHEDULER_SCHEDULER=laravel #laravel, crunz
    UISCHEDULER_MUTEX=redis #file, redis | if (file or redis) change CACHE_DRIVER too
    CACHE_DRIVER=redis #file, redis
        
## Debug
1. Clear and reset all
    php artisan config:clear
    php artisan cache:clear

    composer dump-autoload
2. Redis
    php artisan tinker
    redis-cli
    KEYS *
3. Crontab
    grep CRON /var/log/syslog
4. CrunzPHP
    vendor/bin/crunz schedule:run
    vendor/bin/crunz schedule:list

## Known problems
1. Timezone
    cat /etc/timezone
    php -i | grep timezone

## Server installation
1. Prerequisites
    Ubuntu
2. Install Apache, PHP, MYSQL
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
3. Install Composer
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    sudo chmod +x /usr/local/bin/composer
    composer --version
    composer
    cd /var/www/html