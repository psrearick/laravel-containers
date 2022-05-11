<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;

class AddItemToContainer
{
    public function execute(Container $container, Item $item, ?array $attributes = []) : void
    {
        $relationMethod = $container->containsRelationName($item);
        $relation       = $container->$relationMethod();
        $containerItem  = $item->containerItem($container);

        if ($containerItem && ! ($containerItem->isSummarized ?? false)) {
            app(UpdateContainerItem::class)->execute($container, $item, $attributes);

            return;
        }

        $relation->attach($item->id);
        Event::dispatch(new ContainerItemWasCreated($container->refresh(), $item->refresh(), $attributes));
    }
}
