<?php

namespace Psrearick\Containers\Listeners;

use Psrearick\Containers\Actions\UpdateContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemWasCreated;
use Psrearick\Containers\Events\ContainerItemWasUpdated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerItemParentListener
{
    public function handle(ContainerItemWasCreated|ContainerItemWasUpdated $event) : void
    {
        $container = app(ContainerItemManagerService::class)
            ->serviceFromContainerItem($event->containerItem)
            ->container();

        if (! $container instanceof Item) {
            return;
        }

        $relations = $container->containerItemRelations();

        if (! array_key_exists('item', $relations)) {
            return;
        }

        foreach (array_keys($relations['item']) as $relation) {
            $parents = $container->getContainersOfType($relation);
            if ($parents->count() === 0) {
                continue;
            }

            $parents->each(function ($parent) use ($container) {
                $parentContainerItem = app(ContainerItemManagerService::class)
                    ->service($parent, $container)
                    ->containerItem();
                app(UpdateContainerItem::class)->execute($parentContainerItem);
            });
        }
    }
}
