<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Concerns\HasQuantity;
use Psrearick\Containers\Contracts\Summary as SummaryContract;

class Summary extends Model implements SummaryContract
{
    use HasComputations;
    use HasQuantity;

    protected array $computeAttributes = ['quantity'];

    protected $guarded = ['id'];

    protected string $quantityFieldName = 'quantity';
}
