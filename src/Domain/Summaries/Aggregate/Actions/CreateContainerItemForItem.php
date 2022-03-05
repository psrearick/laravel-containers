<?php

namespace Psrearick\Containers\Domain\Summaries\Aggregate\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Domain\Items\Aggregate\ItemsAggregateRoot;

class CreateContainerItemForItem
{
    public function execute(Item $item) : void
    {
        /** @var ItemsAggregateRoot $root */
        $root = $item->root();
        foreach ($root->containers as $container) {
            /** @var Container $containerModel */
            $containerModel = app($container['class'])::uuid($container['uuid']);

            /** @var ContainerItem $containerItem */
            $containerItem = $item
                ->containerItems()
                ->make([
                    'quantity' => $root->quantity,
                ]);

            $containerItem
                ->containerable()
                ->associate($containerModel)
                ->save();
        }
    }
}
