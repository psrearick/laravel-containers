<?php

namespace Psrearick\Containers\Actions;

use Event;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Contracts\SummarizableContainer;
use Psrearick\Containers\Contracts\SummarizableItem;
use Psrearick\Containers\Contracts\Summarized;
use Psrearick\Containers\Events\ItemWasRemovedFromContainer;
use Psrearick\Containers\Contracts\ContainerItem;

class RemoveItemFromContainer
{
    private ?Summarized $model = null;

    public function execute(Item $item, Container $container) : void
    {
        /** @var ContainerItem $model */
        $model = $item->getContainerItemRelationForContainer($container)->getModel();

        if ($item instanceof SummarizableItem && $container instanceof SummarizableContainer && $model->isSummarized()) {
            /** @var Summarized $model */
            $this->model = $model;
            $this->removeSummarizedContainerItem($item, $container);
            return;
        }

        $containerItem = $item->getContainerItem($container);

        $attributes = array_filter($item->computations(),
            fn ($value, $key) => array_key_exists($key, $containerItem->toArray()),
            ARRAY_FILTER_USE_BOTH);

        array_walk($attributes, function (&$value, $key) use ($containerItem) {
            if (array_key_exists($key, $containerItem->toArray())) {
                $value = -1 * $containerItem->$key;
            }
        });

        app(UpdateContainerItem::class)->execute($container, $item, $attributes);

        Event::dispatch(new ItemWasRemovedFromContainer($container, $item, []));
    }

    private function removeSummarizedContainerItem(SummarizableItem $item, SummarizableContainer $container) : void
    {
        $relations  = $item->containerItemSummaryRelations();
        $class      = $this->model ? get_class($this->model) : '';

        if (!array_key_exists($class, $relations)) {
            return;
        }

        $summary        = $item->{$relations[$class]}()->where('container_id', '=', $container->id)->first();
        if (!$summary) {
            return;
        }

        $attributes = array_filter($this->model->computations(),
            fn ($value, $key) => array_key_exists($key, $summary->toArray()),
            ARRAY_FILTER_USE_BOTH);

        array_walk($attributes, function (&$value, $key) use ($summary) {
            if (array_key_exists($key, $summary->toArray())) {
                $value = -1 * $summary->$key;
            }
        });

        app(AddItemToContainer::class)->execute($container, $item, $attributes);

        Event::dispatch(new ItemWasRemovedFromContainer($container, $item, $attributes));
    }
}
