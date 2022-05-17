<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerItem
{
    public function execute(ContainerItem $containerItem) : ?ContainerItem
    {
//        ray($containerItem, $containerItem->item, $containerItem->container);

        ray(app(GetContainerItemTotals::class)->execute($containerItem->container, $containerItem->item));

        $updates = collect($attributes)->map(function ($value, $key) use ($containerItem) {
            $action = $value >= 0 ? 'add' : 'remove';

            return app($containerItem->computations()[$key][$action])->execute(
                $containerItem->$key ?? null,
                $value
            );
        })->all();

        $containerItem->update($updates);

        Event::dispatch(new ContainerItemWasUpdated($containerItem));

        return $containerItem;
    }
}
