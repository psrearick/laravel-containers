<?php

namespace Psrearick\Containers\Actions;

use Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Events\ItemWasRemovedFromContainer;

class RemoveItemFromContainer
{
    public function execute(Item $item, Container $container) : void
    {
        $attributes = array_map(
            fn ($value) => -1 * $value,
            app(GetContainerItemTotals::class)->execute($container, $item)
        );

        /** @var ContainerItem $model */
        $model = $item->getContainerItemRelationForContainer($container)->getModel();

        if ($item instanceof SummarizableItem && $container instanceof SummarizableContainer && $model->isSummarized()) {
            app(AddItemToContainer::class)->execute($container, $item, $attributes);
            Event::dispatch(new ItemWasRemovedFromContainer($container, $item, $attributes));

            return;
        }

        app(UpdateContainerItem::class)->execute($container, $item, $attributes);

        Event::dispatch(new ItemWasRemovedFromContainer($container, $item, $attributes));
    }
}
