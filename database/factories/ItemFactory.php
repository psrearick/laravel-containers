<?php

namespace Psrearick\Containers\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Domain\Containers\Models\Container;
use Psrearick\Containers\Domain\Items\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition() : array
    {
        return [
            'uuid'              => $this->faker->uuid,
            'model'             => Item::class,
            'name'              => $this->faker->words(3, true),
            'description'       => $this->faker->words(10, true),
        ];
    }
}
