<?php

namespace Psrearick\Containers\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition() : array
    {
        return [
            'uuid'              => $this->faker->uuid,
            'model'             => $this->model,
            'name'              => $this->faker->words(3, true),
            'description'       => $this->faker->words(10, true),
        ];
    }
}
