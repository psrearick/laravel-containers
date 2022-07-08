# laravel-containers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/psrearick/laravel-containers.svg?style=flat-square)](https://packagist.org/packages/psrearick/laravel-containers)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/psrearick/laravel-containers/run-tests?label=tests)](https://github.com/psrearick/laravel-containers/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/psrearick/laravel-containers/Check%20&%20fix%20styling?label=code%20style)](https://github.com/psrearick/laravel-containers/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/psrearick/laravel-containers.svg?style=flat-square)](https://packagist.org/packages/psrearick/laravel-containers)



## Features

* An item can be added to a container
* Items can be moved between containers
* Items can be removed from containers
* An item can be in multiple containers
* Items can have characteristics
* All items within a container have a quantity


* Containers can have multiple items
* Containers can be infinitely nested
* Containers can compute characteristic summaries of their items
* Containers can compute characteristic summaries of their sub-containers
* Nested containers can be moved between containers
* Nested containers can be moved out of containers
* Containers can be deleted
* Container characteristic summaries are updated when an item is added, removed, or moved
* Container characteristic summaries are updated when one of its item's characteristics are updated
* Containers cannot have a quantity


* Containers and items can exist independently of each other
* Items cannot have a quantity if they are not in a container
* An item cannot be in a container if the item's quantity is 0


### Maybe?
* Containers can have characteristics
* Containers and items can be searched by characteristic
* ContainerItem's can store item change history or be singleton, displaying the most recent data





## Installation

You can install the package via composer:

```bash
composer require psrearick/laravel-containers
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-containers-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-containers-config"
```

## Usage

See [EXAMPLE](EXAMPLE.md) for usage details.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Credits

- [Phillip Rearick](https://github.com/psrearick)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
