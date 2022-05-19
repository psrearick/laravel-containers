<?php

namespace Psrearick\Containers;

use Psrearick\Containers\Providers\ContainerItemManagerServiceProvider;
use Psrearick\Containers\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ContainersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package) : void
    {
        $package
            ->hasConfigFile('containers')
            ->name('laravel-containers');
    }

    public function registeringPackage() : void
    {
        parent::registeringPackage();

        $this->app->register(EventServiceProvider::class);
        $this->app->register(ContainerItemManagerServiceProvider::class);
    }
}
