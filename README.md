<!-- # Lumen PHP Framework

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

## Contributing

Thank you for considering contributing to Lumen! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT). -->

# Portfolio API v1

- PHP Version

```shell
PHP 7.4
```

- System Dependencies

```shell
Lumen 8.3.1
Composer 2.3.5
PostgreSQL 15.0
Laradock
```

- Configuration

```shell
composer install
composer dump-autoload
php artisan key:generate
php artisan jwt:secret

docker-compose up -d nginx postgres
```

- Database Initialization

```shell
php artisan migrate
php artisan db:seed
```

- How to run the Test Suite

```shell
docker exec -it WORKSPACE_NAME bash

phpunit --testdox

or

phpunit --testdox --filter=HealthTest
```

---

Fair Use
