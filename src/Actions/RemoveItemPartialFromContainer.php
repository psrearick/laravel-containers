<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;

class RemoveItemPartialFromContainer
{
    public function execute(Container $container, Item $item, array $attributeChange) : void
    {
        $attributes = array_map(
            fn ($value) => -1 * $value,
            $attributeChange
        );

        app(AddItemToContainer::class)->execute($container, $item, $attributes);
    }
}
