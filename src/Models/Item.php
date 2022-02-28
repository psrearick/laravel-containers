<?php

namespace Psrearick\Containers\Models;

use Psrearick\Containers\Database\Factories\ItemFactory;
use Psrearick\Containers\Models\Base\Item as Base;

class Item extends Base
{
    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }
}
