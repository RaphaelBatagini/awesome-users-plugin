# Awesome Users Plugin

> A WordPress plugin to list external users into a virtual page.

 ![PHP version](https://img.shields.io/badge/php-7.4%2B-7a86b8)
 ![WordPress version](https://img.shields.io/badge/WordPress-6%2B-117ac9)
 ![React version](https://img.shields.io/badge/React-17-61dafb)
 [![GPLv2 License](https://img.shields.io/badge/license-GPL--2.0-orange)](https://github.com/RaphaelBatagini/awesome-users-plugin/blob/main/LICENSE.md)

## Table of Contents
* [Technologies](#technologies)
* [Plugin usage](#plugin-usage)
  * [API endpoints](#api-endpoints)
  * [Front-end](#front-end)
  * [Cache](#cache)
* [Install](#install)
  * [Composer dependencies](#composer-dependencies)
  * [NPM dependencies](#npm-dependencies)
* [Interacting with plugin code](#interacting-with-plugin-code)
  * [Checking code standards](#checking-code-standards)
  * [Executing unit tests](#executing-unit-tests)
* [Changelog](#changelog)
* [License](#license)
* [Improvements to be done](#improvements-to-be-done)

## Technologies
- PHP >= 7.4
- Composer 2
- PHPUnit 9.5
- Mockery 1.5
- WP_Mock 0.5
- FakerPHP 1.2
- React 17.0
- ReactDOM 17.0
- Webpack 5.75
- Babel 7.20
- WordPress Dependency Extration Webpack Plugin 4.5
## Plugin usage
### API endpoints
This plugin expose two API endpoints to deal with users. They are:
- Users List - /wp-json/awesome-users/v1/list
- User Details - /wp-json/awesome-users/v1/details/**{user_id}**

### Front-end
The plugin front-end page can be found at this URL:
```
https://YOUR_WEBSITE.COM/my-awesome-users
```
### Cache
The plugin makes use of <a href="https://developer.wordpress.org/reference/classes/wp_object_cache/" target="_blank">WP_Object_Cache</a> in its external http requests, so it's completely viable to work with persistent cache plugins and tools like Redis or Memcached if you want more performance.

The cache can be easy applied to another functions just using the CacheTool utility like the example below:
```php
$result = CacheTool::execute('key', function () {
    return someSlowProcess();
});
```
The closure will only be executed if the key is not cached.

## Install
### Composer dependencies
Use the command below to install and load composer dependencies:
```sh
$ composer install
```

### NPM dependencies
Use the command below to install NPM dependencies and generate front-end assets:
```sh
$ npm run build
```

## Interacting with plugin code

### Checking code standards
```sh
$ vendor/bin/phpcs
```
### Executing unit tests
```sh
$ vendor/bin/phpunit
```
## Change Log
The plugin change log can be found [here](./CHANGELOG.md).
## License
The plugin license can be found [here](./LICENSE.md).

## Improvements to be done
- Increase unit tests coverage;
- Add SASS and use it to style the plugin page;
- Create an NPM dev script with hot reload support;
- Change front-end build to support JSX extension and TypeScript.