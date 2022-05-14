<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Contracts\Summary as SummaryContract;

class Summary extends Model implements SummaryContract
{
    protected $guarded = ['id'];
}
