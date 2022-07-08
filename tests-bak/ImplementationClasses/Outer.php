<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Psrearick\Containers\Models\Container as Base;
use Psrearick\Containers\Tests\Factories\OuterFactory;

class Outer extends Base
{
    use HasFactory;

    protected array $containerItemRelations = [Container::class => 'containerOuters'];

    public function containerOuters() : HasMany
    {
        return $this->hasMany(ContainerOuter::class);
    }

    protected static function newFactory() : OuterFactory
    {
        return OuterFactory::new();
    }
}
