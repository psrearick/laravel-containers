<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $model
 * @property string $uuid
 * @property int|null $quantity
 * @property array $attributes
 * @property-read Collection|null $containerItems
 */
interface Item extends Eventable
{
    public function actions() : array;

    public function containerItems() : MorphMany;

    public function containerModels() : array;

    public function containers() : Collection;
}
