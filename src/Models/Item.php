<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Concerns\IsItemable;
use Psrearick\Containers\Contracts\Item as ItemContract;

class Item extends Model implements ItemContract
{
//    use HasComputations;
    use IsItemable;

//    protected array $computeAttributes = ['quantity'];

    protected array $containerItemRelations = [];

    protected $guarded = ['id'];

    public function containerItemRelations() : array
    {
        return $this->containerItemRelations;
    }
}
