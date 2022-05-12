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
        $relatedRecords = $item->getContainerRelationRecords($container);

        if (count($relatedRecords) !== 0 && ! $relatedRecords->last()->isSummarized()) {
            app(UpdateContainerItem::class)->execute($container, $item, $attributes);

            return;
        }

        $container->getContainerItemRelationForItem($item)
            ->create([$item->getItemForeignKeyName($container) => $item->id]);

        Event::dispatch(new ContainerItemWasCreated($container, $item, $attributes));
    }
}
