<?php

namespace Psrearick\Containers\Actions;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Exceptions\ContainerItemNotFoundException;

class GetContainerItemTotals
{
    private ?Summarized $model = null;

    public function execute(Container $container, Item $item) : array
    {
        /** @var ContainerItem $model */
        $model = $item->getContainerItemRelationForContainer($container)->getModel();

        if ($item instanceof SummarizableItem && $container instanceof SummarizableContainer && $model->isSummarized()) {
            /** @var Summarized $model */
            $this->model = $model;

            return $this->validateQuantity($this->getSummarizedTotals($item, $container));
        }

        $containerItem  = $item->getContainerItem($container, 'item');
        $attributes     = array_filter(
            $containerItem->computations()[get_class($item)],
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

    private function getSummarizedTotals(SummarizableItem $item, SummarizableContainer $container) : array
    {
        $relations  = $item->containerItemSummaryRelations();
        $class      = $this->model ? get_class($this->model) : '';

        if (! array_key_exists($class, $relations)) {
            throw new ContainerItemNotFoundException();
        }

        $summaryRelation    = $item->{$relations[$class]}();
        $foreignKey         = $summaryRelation->getModel()->container()->getForeignKeyName();
        $summary            = $summaryRelation->where($foreignKey, '=', $container->id)->first();

        if (! $summary) {
            throw new ContainerItemNotFoundException();
        }

        $attributes = array_filter(
            $this->model->computations()[get_class($item)],
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
