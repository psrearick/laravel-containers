<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method Container refresh()
 * @property Collection $containerItems
 */
interface Container extends Model
{
    public function containerItemRelations() : array;

    public function itemRelationName(Item $item) : string;

    public function itemRelationRecords(Item $item) : Collection;
}
