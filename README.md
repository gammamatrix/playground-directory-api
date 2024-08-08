# Playground: Directory API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-directory-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-directory-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-directory-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The Playground: Directory API package.

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-directory-api
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/playground-directory-api.php](config/playground-directory-api.php)

## Cloc

```sh
composer cloc
```

```
➜  playground-directory-api git:(develop) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
```

## PHPStan

Tests at level 9 on:
- `config/`
- `database/`
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
