<?php

namespace Psrearick\Containers\Traits;

use Psrearick\Containers\Domain\Summaries\Aggregate\Actions\CreateContainerItemForItem;

trait ItemBaseActions
{
    protected array $actions = [
        'created' => [
            CreateContainerItemForItem::class,
        ],
    ];

    public function actions() : array
    {
        return $this->actions;
    }
}
