<?php

namespace Psrearick\Containers\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\Container;

class ContainerFactory extends Factory
{
    protected $model = Container::class;

    public function definition() : array
    {
        return [
            'uuid'          => $this->faker->uuid,
            'model'         => Container::class,
            'name'          => $this->faker->words(3, true),
            'description'   => $this->faker->words(10, true),
        ];
    }
}
