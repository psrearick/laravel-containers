<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Events\ContainerItemWasUpdated;

class UpdateContainerItem
{
    public function execute(ContainerItem $parentContainerItem) : ?ContainerItem
    {
        return null;

//        /** @var Container $container */
//        $container = $parentContainerItem->{$parentContainerItem->containerItemRelations()['container']};
//
//        $childClasses = $container->containerItemRelations()['container'];
//
//        foreach (array_keys($childClasses) as $class) {
//            $children = $container->getItemsOfType($class);
//            $children->each(function ($child) use ($container) {
//                ray(app(GetContainerItemTotals::class)->execute($container, $child));
//            });
//        }
//
//        return null;

//        Event::dispatch(new ContainerItemWasUpdated($containerItem));
//
//        return $containerItem;
    }
}
