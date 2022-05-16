<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerItemParentListener
{
    public function handle(ContainerItemWasUpdated $event) : void
    {
        $containerItem  = $event->containerItem;
        $container      = $containerItem->{$containerItem->containerItemRelations()['container']};
        $item           = $containerItem->{$containerItem->containerItemRelations()['item']};

        if (! $container instanceof Item) {
            return;
        }

        $relations = $container->containerItemRelations();

        if (! array_key_exists('item', $relations)) {
            return;
        }

//        foreach (array_keys($relations['item']) as $relation) {
//            $parents = $container->getContainersOfType($relation);
//            if ($parents->count() === 0) {
//                continue;
//            }
//
//            $parents->each(function ($parent) use ($container, $attributes) {
//                app(UpdateContainerItem::class)->execute($parent, $container, $attributes);
//            });
//        }
    }
}
