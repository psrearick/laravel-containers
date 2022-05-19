<?php

namespace Psrearick\Containers\Actions;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Events\ContainerItemSummaryWasUpdated;
use Psrearick\Containers\Services\ContainerItemManagerService;

class UpdateContainerItemSummary
{
    public function execute(Container $container, Item $item) : void
    {
        $service = app(ContainerItemManagerService::class)->service($container, $item);

        $computations = $service->computationsForSummary();

        $updates = $service->containerItems()->reduce(function ($carry, $item) use ($computations) {
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

        $summary = $service->updateOrCreateSummary($updates)->summary();

        Event::dispatch(new ContainerItemSummaryWasUpdated($summary));
    }
}
