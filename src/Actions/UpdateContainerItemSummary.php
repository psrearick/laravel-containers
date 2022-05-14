<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Events\ContainerItemSummaryWasUpdated;

class UpdateContainerItemSummary
{
    public function execute(Summarized $containerItem) : void
    {
        $computations      = $containerItem->computations();
        $relations         = $containerItem->containerItemRelations();
        $containerRelation = $containerItem->{$relations['container']}();
        $container         = $containerRelation->first();
        $containerKey      = $containerRelation->getForeignKeyName();
        $itemRelation      = $containerItem->{$relations['item']}();
        $item              = $itemRelation->first();
        $itemKey           = $itemRelation->getForeignKeyName();

        $containerItems = app(get_class($containerItem))::query()
            ->where($containerKey, '=', $container->id)
            ->where($itemKey, '=', $item->id)
            ->get();

        $updates = $containerItems->reduce(function ($carry, $item) use ($computations) {
            return collect($computations)->map(function ($class, $field) use ($carry, $item) {
                return app($class['add'])->execute(
                    $carry[$field],
                    $item[$field],
                );
            })->all();
        }, array_fill_keys(array_keys($computations), 0));

        $relation = $containerItem->summarizedBy();

        $summary = app(get_class($containerItem->$relation()->getRelated()))->updateOrCreate(
            [
                $containerKey => $container->id,
                $itemKey      => $item->id,
            ],
            $updates
        );

        $containerItem->$relation()->associate($summary);
        $containerItem->save();

        Event::dispatch(new ContainerItemSummaryWasUpdated($summary));
    }
}
