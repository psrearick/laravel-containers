<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\Summarized;

class RemoveItemPartialFromContainer
{
    private ?Summarized $model = null;

    public function execute(Container $container, Item $item, array $attributeChange) : void
    {
        $attributes = array_map(
            fn ($value) => -1 * $value,
            $attributeChange
        );

        app(AddItemToContainer::class)->execute($container, $item, $attributes);
    }
}
