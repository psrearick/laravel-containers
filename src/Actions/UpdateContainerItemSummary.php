<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Summarized;

class UpdateContainerItemSummary
{
    public function execute(Summarized $containerItem) : void
    {
        $ids          = $containerItem->foreignIds();
        $computations = $containerItem->computations();

        $containerItems = app(get_class($containerItem))::query()
            ->where($ids['container'], '=', $containerItem[$ids['container']])
            ->where($ids['item'], '=', $containerItem[$ids['item']])
            ->get();

        $updates = $containerItems->reduce(function ($carry, $item) use ($computations) {
            return collect($computations)->map(function ($class, $field) use ($carry, $item) {
                return app($class)->execute(
                    $carry[$field],
                    $item[$field],
                );
            })->all();
        }, array_fill_keys(array_keys($computations), 0));

        app($containerItem->summaryClass())::updateOrCreate([
            $ids['container']    => $containerItem[$ids['container']],
            $ids['item']         => $containerItem[$ids['item']],
        ], $updates);
    }
}
