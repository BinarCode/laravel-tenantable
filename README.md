# Laravel Tenantable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/binarcode/y.svg?style=flat-square)](https://packagist.org/packages/binarcode/y)

![Tests](https://github.com/BinarCode/laravel-tenantable/workflows/Tests/badge.svg?branch=master)

Just another multi tenant support package for Laravel. Heavily inspired from [Mohamed Said](https://github.com/themsaid) multitenancy videos. 

I started working on this at the same time or even before [spatie](https://github.com/spatie/laravel-multitenancy) started, because we need it for a real project, and it was part of that project. Now I've decided to move it into a separate package, so we can separate the logic, tests and support for this module.

## Installation

You can install the package via composer:

```bash
composer require binarcode/laravel-tenantable
```

Now lets setup it:

```bash
php artisan tenantable:setup
```

## Usage

Let's say you have the `App\Models\Orgnization` as a tenant model. 

This model has to implement the `BinarCode\Tenantable\Tenant\Contracts\Tenant` contract.

If you want to benefit of all of the methods the contract as you to implement, just extends the `BinarCode\Tenantable\Models\Tenant` class, and you don't have to add anything else in your model.

Now I'll take it step by step, since I was very confused when I implemented my firt multitenancy application. 


### Migrations

You need 2 types of migrations, `master` and `tenant`. The migrations in the `app\database\migrations` directory, are used for `tenant`. If you have to add migrations for the `master` use `app\database\migrations\master` directory.


...to be continue


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
