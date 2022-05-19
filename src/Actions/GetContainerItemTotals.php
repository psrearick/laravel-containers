<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;
use Psrearick\Containers\Services\ContainerItemManagerService;
use Psrearick\Containers\Services\ContainerItemService;

class GetContainerItemTotals
{
    public function execute(Container $container, Item $item) : array
    {
        $service = app(ContainerItemManagerService::class)->service($container, $item);
        if ($service->summarized()) {
            return $this->validateQuantity($this->getSummarizedTotals($service));
        }

        $containerItem  = $service->containerItem();
        $attributes     = array_filter(
            $service->computationsForItem(),
            fn ($value, $key) => array_key_exists($key, $containerItem->toArray()),
            ARRAY_FILTER_USE_BOTH
        );

        array_walk($attributes, function (&$value, $key) use ($containerItem) {
            if (array_key_exists($key, $containerItem->toArray())) {
                $value = $containerItem->$key;
            }
        });

        return $this->validateQuantity($attributes);
    }

    private function getSummarizedTotals(ContainerItemService $service) : array
    {
        $summary = $service->summary();

        if (! $summary) {
            throw new ContainerItemNotFoundException();
        }

        $attributes = array_filter(
            $service->computationsForItem(),
            fn ($value, $key) => array_key_exists($key, $summary->toArray()),
            ARRAY_FILTER_USE_BOTH
        );

        array_walk($attributes, function (&$value, $key) use ($summary) {
            if (array_key_exists($key, $summary->toArray())) {
                $value = $summary->$key;
            }
        });

        return $attributes;
    }

    private function validateQuantity(array $attributes) : array
    {
        if (! array_key_exists('quantity',  $attributes)) {
            return $attributes;
        }

        if ((float) $attributes['quantity'] === 0.0) {
            throw new ContainerItemNotFoundException();
        }

        return $attributes;
    }
}
