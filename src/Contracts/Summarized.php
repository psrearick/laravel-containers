<?php

namespace Psrearick\Containers\Contracts;

interface Summarized extends ContainerItem
{
    public function computations() : array;

    public function foreignIds() : array;

    public function summaryClass() : string;
}
