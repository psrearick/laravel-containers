<?php

namespace Psrearick\Containers\Traits;

trait ContainerBaseActions
{
    protected array $actions = [];

    public function actions() : array
    {
        return $this->actions;
    }
}
