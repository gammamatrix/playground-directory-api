# Playground: Directory API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-directory-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-directory-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-directory-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The Playground: Directory API package.

## Documentation

### Swagger

This application provides Swagger documentation: [swagger.json](swagger.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

Swagger API Documentation is built with npm.
- npm is only needed to generate documentation and is not needed to operate the CMS API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [swagger.json](swagger.json) configuration.

```sh
npm run docs
```

Documentation
- Preview [swagger.json on the Swagger Editor UI.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gammamatrix/playground-directory-api/develop/swagger.json)
- Preview [swagger.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-directory-api/develop/swagger.json)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-directory-api
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/playground-directory-api.php](config/playground-directory-api.php)

You can publish the config file with:
```bash
php artisan vendor:publish --provider=Playground\Directory\Api\ServiceProvider" --tag="playground-config"
```

## Cloc

```sh
composer cloc
```

```
➜  playground-directory-api git:(develop) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
     195 text files.
     121 unique files.
      76 files ignored.

github.com/AlDanial/cloc v 1.98  T=0.24 s (504.6 files/s, 98625.1 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                             5              0              0          14524
PHP                             81            689           1139           3883
YAML                            28              5              0           3051
XML                              3              0              7            215
Markdown                         3             37              0             85
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           121            734           1146          21770
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 9 on:
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

```sh
composer test --parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
