<?php

namespace Psrearick\Containers\Contracts;

/**
 * @method Item refresh()
 */
interface Item extends Model
{
    public function computations() : array;

    public function containedBy() : array;

    public function containerItem(Container $container) : ?ContainerItem;

    public function lastContainerItem(Container $container) : ?ContainerItem;

    public function relationName(Container $container) : string;
}
