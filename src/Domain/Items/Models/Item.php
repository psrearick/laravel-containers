<?php

namespace Psrearick\Containers\Domain\Items\Models;

use Psrearick\Containers\Database\Factories\ItemFactory;
use Psrearick\Containers\Domain\Items\Models\Base\Item as Base;

class Item extends Base
{
    protected static function newFactory() : ItemFactory
    {
        return ItemFactory::new();
    }
}
