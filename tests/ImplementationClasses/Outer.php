<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Concerns\IsContainerable;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Tests\Factories\OuterFactory;

class Outer extends Model implements ContainerContract
{
    use HasFactory;
    use IsContainerable;

    public function containerItemRelations() : array
    {
        return [Container::class => 'containerOuters'];
    }

    public function containerOuters() : HasMany
    {
        return $this->hasMany(ContainerOuter::class);
    }

//    public function containerOuters() : HasMany
//    {
//        return $this->hasMany(ContainerOuter::class);
//    }
//
//    public function contains() : array
//    {
//        return [Container::class => 'containers'];
//    }

    protected static function newFactory() : OuterFactory
    {
        return OuterFactory::new();
    }
}
