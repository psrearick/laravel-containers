<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Tests\Factories\OuterFactory;

class Outer extends Model
{
    use HasFactory;

    protected static function newFactory() : OuterFactory
    {
        return OuterFactory::new();
    }
}
