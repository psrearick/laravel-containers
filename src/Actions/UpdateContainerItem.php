<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerItem
{
    public function execute(Container $container, Item $item, array $attributes) : void
    {
        $containerItem = $item->containerItem($container);

        if (! $attributes) {
            return;
        }

        $updates = collect($attributes)->map(function ($value, $key) use ($item, $containerItem) {
            return app($item->computations()[$key])->execute(
                $containerItem->$key ?? null,
                $value
            );
        })->all();

        $relation = $container->containsRelationName($item);
        $container->$relation()->updateExistingPivot($item->id, $updates);

        Event::dispatch(new ContainerItemWasUpdated($containerItem->refresh()));
    }
}
