<?php

namespace Psrearick\Containers\Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Psrearick\Containers\Tests\ImplementationClasses\ContainerNotSummarized;

class ContainerNotSummarizedFactory extends Factory
{
    protected $model = ContainerNotSummarized::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->words(3, true),
        ];
    }
}
