# Awesome Users Plugin

> A WordPress plugin to list external users into a virtual page.

 ![Test status](https://github.com/RaphaelBatagini/awesome-users-plugin/actions/workflows/tests.yml/badge.svg?branch=main) ![PHP version](https://img.shields.io/badge/php-7.4%2B-7a86b8)
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
- PHP 7.4+ - At the moment the most recent version of PHP supported by WordPress;
- WordPress 6+ - The latest version of WordPress which gives us support for some front-end resources described below;
- Composer 2 - The latest version of Composer;
- PHPUnit 9.5 - The latest version supported by PHP previous to version 8;
- Mockery 1.5 - Mock classes out of the PHPUnit default scope;
- WP_Mock 0.5 - Mock WordPress user functions;
- FakerPHP 1.2 - Generate unit tests random data making tests results more reliable;
- NodeJS 14.0+ - Dependency for the front-end resources listed below;
- Webpack 5.75 - Manage front-end build process;
- Babel 7.20 - Transpile React code to ES5;
- React 17.0 - Javascript library used to consume the plugin APIs asynchronous. Has not been installed apart of WordPress as explained below;
- WordPress Dependency Extration Webpack Plugin 4.5 - Webpack plugin to allow consuming WordPress front-end resources, like React and its components, importing then as modules in others Javascript files.
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
The plugin makes use of <a href="https://developer.wordpress.org/reference/classes/wp_object_cache/" target="_blank">WP_Object_Cache</a> when doing external http requests, so it's completely viable to work with persistent cache plugins and tools like Redis or Memcached if you want more performance.

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
### Download
You can also download the plugin from the repository releases [here](https://github.com/RaphaelBatagini/awesome-users-plugin/releases).

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
