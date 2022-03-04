<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Psrearick\Containers\Domain\Items\Aggregate\ItemsAggregateRoot;

/**
 * @property int|null $quantity
 * @property array $attributes
 */
interface Item extends Model
{
    public function actions() : array;

    public function aggregateAttributes() : array;

    public function containerItems() : MorphMany;

    public function containerModels() : array;

    public function containers() : Collection;

    public function root() : ?ItemsAggregateRoot;
}
