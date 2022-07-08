<?php

namespace Psrearick\Containers\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\Container;

class ContainerFactory extends Factory
{
    protected $model = Container::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->words(3, true),
        ];
    }
}
