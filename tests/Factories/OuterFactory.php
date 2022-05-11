<?php

namespace Psrearick\Containers\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\Outer;

class OuterFactory extends Factory
{
    protected $model = Outer::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->words(3, true),
        ];
    }
}
