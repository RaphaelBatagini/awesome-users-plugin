# Awesome Users Plugin

## Plugin usage

## Technologies
- PHP >= 7.4
- Composer 2
- PHPUnit 9.5

## API Endpoints
This plugin expose two API endpoints to deal with users. They are:
- Users List - /wp-json/awesome-users/v1/list
- User Details - /wp-json/awesome-users/v1/details/{user_id}

## Interacting with plugin code

### Checking code standards
```sh
$ vendor/bin/phpcs
```

### Executing unit tests
```sh
$ vendor/bin/phpunit
```