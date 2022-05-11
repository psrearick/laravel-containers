<?php

namespace Psrearick\Containers\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->words(3, true),
        ];
    }
}
