# Laravel 5.3

## Description

Search an artist database by name, after logging in with Google using OAuth2

## Build and Run.
1.   Run Composer package manager (composer.phar is provided in the folder):
```
    ./composer.phar self-update
    ./composer.phar update
```
2.  Create a new database in mysql. For example:

```
    echo "CREATE DATABASE artistsdemo" | mysql -u USER -pPASSWORD
```
3.  create .env file from a copy of .env-example, and modify database and connection settings to new database:
```
    cp .env.example .env
    emacs .env  [or your favorite editor]
```
4.  Modify mysql connection settings in .env
```
    DB_DATABASE=<database name>
    DB_USERNAME=<database user>
    DB_PASSWORD=<database password>
```
5.  Run db migration & database script:
```
    php artisan migrate --seed
```

6.  Generate key:
```
    php artisan key:generate
```

7. Run PHP web service with
```
    php artisan serve
```

8. Go to http://127.0.0.1:8000 for docs and link to app



To run tests (phpUnit is included in folder):

      ./phpunit-5.7.5.phar



On Installing PHP
=================
PHP 5.6.4+ is needed mainly for running phpUnit tests. It is downloadable at:

     http://us2.php.net/get/php-5.6.4.tar.gz/from/this/mirror

This is my configuration for compiling PHP 5.6.4, with mbstring enabled:

./configure --with-mysql --with-mysqli --with-pdo-mysql --with-curl --with-gd \
--with-zlib --with-jpeg-dir=/usr/lib/ --with-openssl --with-mcrypt \
--with-libdir=/lib/x86_64-linux-gnu --enable-mbstring 