<?php

namespace Psrearick\Containers;

use Psrearick\Containers\Providers\EventServiceProvider;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Psrearick\Containers\Commands\ContainersCommand;

class ContainersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-containers')
            ->hasConfigFile()
//            ->hasViews()
//            ->hasMigration('create_laravel-containers_table')
            ->hasCommand(ContainersCommand::class);
    }

    public function registeringPackage() : void
    {
        parent::registeringPackage();

        $this->app->register(EventServiceProvider::class);
    }
}
