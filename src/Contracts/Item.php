<?php

namespace Psrearick\Containers\Contracts;

interface Item extends Model
{
    public function computations() : array;

    public function containedBy() : array;

    public function containerItem(Container $container) : ContainerItem;
}
