<?php

namespace Psrearick\Containers\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\ItemNotSummarized;

class ItemNotSummarizedFactory extends Factory
{
    protected $model = ItemNotSummarized::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->words(3, true),
        ];
    }
}
