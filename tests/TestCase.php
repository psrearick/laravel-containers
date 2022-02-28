<?php

namespace Psrearick\Containers\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Psrearick\Containers\ContainersServiceProvider;
use Psrearick\Containers\Providers\EventServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp() : void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            static fn (string $modelName) => 'Psrearick\\Containers\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app) : void
    {
        config()->set('database.default', 'testing');

        $container_migration = include __DIR__ . '/../database/migrations/create_laravel-containers_table.php.stub';
        $container_migration->up();

        $item_migration = include __DIR__ . '/../database/migrations/create_laravel-items_table.php.stub';
        $item_migration->up();

        $container_items_migration = include __DIR__ . '/../database/migrations/create_laravel-container-items_table.php.stub';
        $container_items_migration->up();
    }

    protected function getPackageProviders($app) : array
    {
        return [
            ContainersServiceProvider::class,
            EventServiceProvider::class,
        ];
    }
}
