<?php

namespace Psrearick\Containers\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method Item refresh()
 */
interface Item extends Model
{
    public function computations() : array;

    public function containerItemRelations() : array;

    public function containerRelationName(Container $container) : string;

    public function containerRelationRecords(Container $container) : Collection;

//    public function containedBy() : array;

//    public function containerItem(Container $container) : ?ContainerItem;

//    public function lastContainerItem(Container $container) : ?ContainerItem;

//    public function relationName(Container $container) : string;
}
