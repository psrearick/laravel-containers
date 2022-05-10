<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;
use Psrearick\Containers\Domain\Containers\Aggregate\Events\ContainerItemWasSaved;

/**
 * @property Container $containerable
 * @property Item $itemable;
 */
trait ContainerItemable
{
    public function containerable() : MorphTo
    {
        return $this->morphTo('containerable', null, 'containerable_uuid', 'uuid');
    }

    public function itemable() : MorphTo
    {
        return $this->morphTo('itemable', null, 'itemable_uuid', 'uuid');
    }

    protected static function bootContainerItemable() : void
    {
        static::saved(static function (ContainerItem $containerItem) {
            ContainerItemWasSaved::dispatch($containerItem);
        });
    }
}
