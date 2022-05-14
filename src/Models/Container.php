<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Concerns\IsContainerable;
use Psrearick\Containers\Contracts\Container as ContainerContract;

class Container extends Model implements ContainerContract
{
    use HasComputations;
    use IsContainerable;

    protected array $computeAttributes = ['quantity'];

    protected array $containerItemRelations = [];

    protected $guarded = ['id'];

    public function containerItemRelations() : array
    {
        return $this->containerItemRelations;
    }
}
