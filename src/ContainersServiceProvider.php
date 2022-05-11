<?php

namespace Psrearick\Containers;

use Psrearick\Containers\Commands\ContainersCommand;
use Psrearick\Containers\Providers\AggregateServiceProvider;
use Psrearick\Containers\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ContainersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package) : void
    {
        $package
            ->name('laravel-containers');
    }

    public function registeringPackage() : void
    {
        parent::registeringPackage();

        $this->app->register(EventServiceProvider::class);

        $this->app->bind('laravel-containers', function () {
            return new Containers();
        });
    }
}
