<?php

namespace Psrearick\Containers\Computations\Actions;

class GetQuantityMultipleResult
{
    public function execute(array $ref, float $newValue) : float
    {
        if (! $ref) {
            return $newValue;
        }

        if (! isset($ref['model'])) {
            return $newValue;
        }

        $quantityFieldName = $ref['quantityFieldName'] ?? 'quantity';

        if (($ref['fieldName'] ?? '') === $ref['model']->$quantityFieldName) {
            return $newValue;
        }

        $attributes = $ref['attributes'] ?? [];

        $quantity   = $attributes[$quantityFieldName] ?? ($ref['model']->$quantityFieldName ?? 1);

        return $newValue * $quantity;
    }
}
