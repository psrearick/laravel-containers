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
        $relation       = $container->itemRelationName($item);
        $relatedRecords = $container->itemRelationRecords($item);
        $itemRelation   = $item->{$item->containerRelationName($container)}();

        if (count($relatedRecords) !== 0 && ! $relatedRecords->last()->isSummarized()) {
            app(UpdateContainerItem::class)->execute($container, $item, $attributes);

            return;
        }

        $container->$relation()->create([$itemRelation->getForeignKeyName() => $item->id]);

        Event::dispatch(new ContainerItemWasCreated($container, $item, $attributes));
    }
}
