<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Events\ContainerWasCreated;
use Psrearick\Containers\Tests\Factories\ContainerFactory;

class Container extends Model implements ContainerContract
{
    use HasFactory;

    protected static function booted() : void
    {
        static::created(function (ContainerContract $container) {
            Event::dispatch(new ContainerWasCreated($container));
        });
    }

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
