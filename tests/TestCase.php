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
            static fn (string $modelName) => 'Psrearick\\Containers\\Tests\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    public function getEnvironmentSetUp($app) : void
    {
        config()->set('database.default', 'testing');

        (include 'Migrations/create_container_items_table.php')->up();
        (include 'Migrations/create_container_outers_table.php')->up();
        (include 'Migrations/create_containers_table.php')->up();
        (include 'Migrations/create_items_table.php')->up();
        (include 'Migrations/create_outers_table.php')->up();
        (include 'Migrations/create_container_item_summaries_table.php')->up();
        (include 'Migrations/create_not_summarized_tables.php')->up();
    }

    protected function getPackageProviders($app) : array
    {
        return [
            ContainersServiceProvider::class,
            EventServiceProvider::class,
        ];
    }
}
