# Onion PHP Official API

api.onion.ar/api

## About Onion

Onion is a company in which we take care of digitizing your business to anticipate and adapt to the future. We develop from the Digital Menu with access by QR to the Web App to receive orders both from the tables of your business and orders for delivery and/or take away.

## Requirements

PHP 7.3 and later.

## Build Setup With Sail (reccomended)

```bash
# install dependencies
$ composer install

# create .env and .env.testing from .env.example
$ touch .env && touch .env.example

# start sail
$ vendor/bin/sail up

# run migrations
$ vendor/bin/sail artisan migrate --seed

# run tests (not run in production)
$ vendor/bin/sail test
# after running test refresh database
vendor/bin/sail artisan migrate:fresh  --seed
```
## Build Setup

```bash
# install dependencies
$ composer install

# create .env and .env.testing from .env.example
$ touch .env && touch .env.example

# run migrations
$ php artisan migrate --seed

# serve with hot reload at localhost:8080
$ php artisan serve

# run tests
$ php artisan test
```

## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

****************************

Made with Laravel 8.x

https://laravel.com/docs/8.x
