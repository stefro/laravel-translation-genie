# This package is heavily under construction. DO NOT USE!

# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/involvedgroup/laravel-translation-genie.svg?style=flat-square)](https://packagist.org/packages/involvedgroup/laravel-translation-genie)
[![Build Status](https://img.shields.io/travis/involvedgroup/laravel-translation-genie/master.svg?style=flat-square)](https://travis-ci.org/involvedgroup/laravel-translation-genie)
[![Quality Score](https://img.shields.io/scrutinizer/g/involvedgroup/laravel-translation-genie.svg?style=flat-square)](https://scrutinizer-ci.com/g/involvedgroup/laravel-translation-genie)
[![Total Downloads](https://img.shields.io/packagist/dt/involvedgroup/laravel-translation-genie.svg?style=flat-square)](https://packagist.org/packages/involvedgroup/laravel-translation-genie)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require involvedgroup/laravel-translation-genie
```

## Usage

There are two artisan commands:
`php artisan translation-genie:update-masterfiles`
This will scan al PHP **AND** JS files and search for translation keys. It will store them in the default Laravel language JSON files.

`php artisan translation-genie:update-js-files`
This command needs to be run **AFTER** the Laravel master JSON files are translated. With this command, a JS translation file will be created that will be used by vue-i18n.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email stef.rouschop@involved.group instead of using the issue tracker.

## Credits

- [Stef Rouschop](https://github.com/involvedgroup)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
