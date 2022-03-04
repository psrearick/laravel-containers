<?php

namespace Psrearick\Containers\Domain\Summaries\Aggregate\Actions;

use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Domain\Containers\Models\ContainerItem;
use Psrearick\Containers\Tests\ImplementationClasses\Container;

class CountContainerItems
{
    public function execute(Item $item) : void
    {
        foreach ($item->root()->containers as $container) {
            /** @var ContainerItem $containerItem */
            $containerItem = $item
                ->containerItems()
                ->make([
                    'quantity' => $item->root()->quantity,
                ]);

            $containerItem
                ->containerable()
                ->associate(Container::uuid($container['uuid']))
                ->save();
        }
    }
}
