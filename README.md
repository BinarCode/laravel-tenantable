# Laravel Tenantable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/binarcode/y.svg?style=flat-square)](https://packagist.org/packages/binarcode/y)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/binarcode/y/run-tests?label=tests)](https://github.com/binarcode/y/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/binarcode/y.svg?style=flat-square)](https://packagist.org/packages/binarcode/y)


Just another multi tenant support package for Laravel. Heavily inspired from [Mohamed Said](https://github.com/themsaid) multitenancy videos. 

I started working on this at the same time or even before [spatie](https://github.com/spatie/laravel-multitenancy) started, because we need it for a real project, and it was part of that project. Now I've decided to move it into a separate package, so we can separate the logic, tests and support for this module.

## Installation

You can install the package via composer:

```bash
composer require binarcode/larave-tenantable
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="BinarCode\Tenantable\TenantableServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="BinarCode\Tenantable\TenantableServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

//

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email eduard.lupacescu@binarcode.com instead of using the issue tracker.

## Credits

- [All Contributors](../../contributors)

## Credits

The code of this package is based on the code shown in [the Multitenancy in Laravel series](https://www.youtube.com/watch?v=592EgykFOz4)  by Mohamed Said

- [Eduard Lupacescu](https://github.com/binaryk)
- [All Contributors](../../contributors)

## Alternatives

- [spatie/laravel-multitenancy](https://github.com/spatie/laravel-multitenancy)
- [tenancy/tenancy](https://tenancy.dev)
- [stancl/tenancy](https://tenancyforlaravel.com)
- [gecche/laravel-multidomain](https://github.com/gecche/laravel-multidomain)
- [romegadigital/multitenancy](https://github.com/romegasoftware/multitenancy)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
