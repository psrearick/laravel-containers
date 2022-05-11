<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\Item as ItemContract;
use Psrearick\Containers\Events\ItemWasCreated;
use Psrearick\Containers\Tests\Factories\ItemFactory;

class Item extends Model implements ItemContract
{
    use HasFactory;

    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }

    protected static function booted() : void
    {
        static::created(function (ItemContract $item) {
            Event::dispatch(new ItemWasCreated($item));
        });
    }
}
