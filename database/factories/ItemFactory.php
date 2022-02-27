<?php

namespace Psrearick\Containers\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Models\Container;
use Psrearick\Containers\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition() : array
    {
        $container = Container::factory()->create();

        return [
            'uuid'              => $this->faker->uuid,
            'model'             => Item::class,
            'container_uuid'    => $container->uuid,
        ];
    }
}
