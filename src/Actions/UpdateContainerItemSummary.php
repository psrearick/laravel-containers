<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Events\ContainerItemSummaryWasUpdated;

class UpdateContainerItemSummary
{
    public function execute(Summarized $containerItem) : void
    {
        $relations          = $containerItem->containerItemRelations();
        $containerRelation  = $containerItem->{$relations['container']}();
        $container          = $containerRelation->first();
        $containerKey       = $containerRelation->getForeignKeyName();
        $itemRelation       = $containerItem->{$relations['item']}();
        $item               = $itemRelation->first();
        $itemKey            = $itemRelation->getForeignKeyName();
        $relation           = $containerItem->summarizedBy();
        $computations       = $containerItem
            ->{$containerItem->summarizedBy()}()
            ->getModel()
            ->computations()[get_class($item)];

        $containerItems = app(get_class($containerItem))::query()
            ->where($containerKey, '=', $container->id)
            ->where($itemKey, '=', $item->id)
            ->get();

        $updates = $containerItems->reduce(function ($carry, $item) use ($computations) {
            return collect($computations)->map(function ($class, $field) use ($carry, $item) {
                $action = $item->$field >= 0 ? 'add' : 'remove';

                return app($class[$action])->execute(
                    $carry[$field] ?: 0,
                    $item->$field ?: 0,
                    [
                        'model'             => $item,
                        'quantityFieldName' => $item->quantityFieldName(),
                        'fieldName'         => $field,
                    ]
                );
            })->all();
        }, array_fill_keys(array_keys($computations), 0));

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
