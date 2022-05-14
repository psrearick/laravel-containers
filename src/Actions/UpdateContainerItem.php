<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerItem
{
    public function execute(Container $container, Item $item, array $attributes) : ?ContainerItem
    {
        $containerItem = $item->getContainerItem($container, 'item');

        if (! $attributes) {
            return null;
        }

        $updates = collect($attributes)->map(function ($value, $key) use ($item, $containerItem) {
            $action = $value > 0 ? 'add' : 'remove';

            return app($item->computations()[$key][$action])->execute(
                $containerItem->$key ?? null,
                $value
            );
        })->all();

        $containerItem->update($updates);

        Event::dispatch(new ContainerItemWasUpdated($containerItem, $attributes));

        return $containerItem;
    }
}
