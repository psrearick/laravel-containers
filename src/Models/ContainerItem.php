<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Contracts\ContainerItem as Contract;

class ContainerItem extends Model implements Contract
{
    protected $guarded = ['id'];

    protected bool $isSummarized = false;

    public function containerItemRelations() : array
    {
        return [
            'container' => 'container',
            'item'      => 'item',
        ];
    }

    public function isSummarized() : bool
    {
        return $this->isSummarized;
    }
}
