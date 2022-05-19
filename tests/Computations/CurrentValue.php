<?php

namespace Psrearick\Containers\Tests\Computations;

use Psrearick\Containers\Contracts\Computation;
use Psrearick\Containers\Services\ContainerItemManagerService;

class CurrentValue implements Computation
{
    public function execute(?float $currentValue = 0, ?float $newValue = 0, ?array $ref = []) : mixed
    {
        $model      = $ref['model'];
        $service    = app(ContainerItemManagerService::class)->service($model->container, $model->item);
        $summary    = $service->summary();
        $updates    = $service->updates();

        if (! $summary || ! $updates) {
            return $model->value * $model->quantity;
        }

        return ($summary->quantity + $updates['quantity']) * $updates['value'];
    }
}
