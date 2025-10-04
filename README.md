# Playground: Directory API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-directory-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-directory-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-directory-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-level%2010-brightgreen)](.github/workflows/ci.yml#L128)

Playground: Directory API

This package provides an API without UI for interacting with the [Playground: Directory](https://github.com/gammamatrix/playground-directory), a model package for Laravel.

If you need a JSON API with a UI, then have a look at [Playground: Directory Resource.](https://github.com/gammamatrix/playground-directory-resource)

## Documentation

Read more on using [Playground: Directory API at Read the Docs: Playground Documentation](https://gammamatrix-playground.readthedocs.io/en/develop/built-components/directory.html)

### Postman

A postman collection is provided in the repository: [postman-playground-directory-api.json.](postman-playground-directory-api.json)
- This same collection is viewable on the [.]()

### OpenAPI

This application provides OpenAPI documentation: [openapi.yaml](openapi.yaml).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the Playground: Directory API API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [openapi.yaml](openapi.yaml) configuration.

```sh
npm run docs
```

Documentation
- Preview [openapi.yaml on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-directory-api/develop/openapi.yaml)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-directory-api
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-directory-api.png" alt="screenshot of artisan about command with Playground: Directory API."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Directory\Api\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via environment variable or the configuration.

See the contents of the published config file: [config/playground-directory-api.php](config/playground-directory-api.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="Playground\Directory\Api\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/playground-directory-api`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/playground-directory-api.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/playground-directory-api/wiki/Environment-Variables)

## Migrations

This package requires the migrations in [playground-directory](https://github.com/gammamatrix/playground-directory) a Laravel package.

## Cloc

```sh
composer cloc
```

```
➜  playground-directory-api git:(develop) ✗ composer cloc
     209 text files.
     202 unique files.
      49 files ignored.

github.com/AlDanial/cloc v 2.06  T=0.06 s (3167.2 files/s, 432312.6 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                            78              0              0          14954
YAML                            30              5              0           6390
PHP                             80            866           1211           3638
XML                             10              0              7            302
Markdown                         3             55              1            128
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           202            929           1219          25424
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
- `config/`
- `lang/`
- `routes/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

Run unit tests:
```sh
composer test
```

Run unit and feature tests:
```sh
composer test-dev
```

Run unit and feature tests in parallel:
```sh
composer test-parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
