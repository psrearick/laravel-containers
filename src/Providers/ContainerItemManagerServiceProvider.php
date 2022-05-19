<?php

namespace Psrearick\Containers\Providers;

use Illuminate\Support\ServiceProvider;
use Psrearick\Containers\Services\ContainerItemManagerService;

class ContainerItemManagerServiceProvider extends ServiceProvider
{
    public function register() : void
    {
        $this->app->singleton(ContainerItemManagerService::class, function () {
            return new ContainerItemManagerService();
        });
    }
}
