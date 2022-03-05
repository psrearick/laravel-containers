<?php

namespace Psrearick\Containers\Domain\Summaries\Aggregate\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;

class CreateContainerItemForItem
{
    public function execute(Item $item) : void
    {
        foreach ($item->root()->containers as $container) {
            /** @var Container $containerModel */
            $containerModel = app($container['class'])::uuid($container['uuid']);

            /** @var ContainerItem $containerItem */
            $containerItem = $item
                ->containerItems()
                ->make([
                    'quantity' => $item->root()->quantity,
                ]);

            $containerItem
                ->containerable()
                ->associate($containerModel)
                ->save();
        }
    }
}
