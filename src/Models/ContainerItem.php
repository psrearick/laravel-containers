<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Concerns\HasQuantity;
use Psrearick\Containers\Concerns\IsContainerItemable;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;

class ContainerItem extends Model implements ContainerItemContract
{
    use HasComputations;
    use HasQuantity;
    use IsContainerItemable;

    protected array $computeAttributes = ['quantity'];

    protected array $containerItemRelations = [
        'container' => 'container',
        'item'      => 'item',
    ];

    protected $guarded = ['id'];

    protected bool $isSingleton = false;

    protected bool $isSummarized = false;

    protected string $quantityFieldName = 'quantity';

    protected string $summarizedBy = '';
}
