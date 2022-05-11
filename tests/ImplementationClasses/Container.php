<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Tests\Factories\ContainerFactory;

class Container extends Model
{
    use HasFactory;

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
