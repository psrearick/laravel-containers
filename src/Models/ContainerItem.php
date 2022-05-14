<?php

namespace Psrearick\Containers\Models;

use Illuminate\Database\Eloquent\Model;
use Psrearick\Containers\Concerns\HasComputations;
use Psrearick\Containers\Contracts\ContainerItem as ContainerItemContract;

class ContainerItem extends Model implements ContainerItemContract
{
    use HasComputations;

    protected array $computeAttributes = ['quantity'];

    protected array $containerItemRelations = [
        'container' => 'container',
        'item'      => 'item',
    ];

    protected $guarded = ['id'];

    protected bool $isSummarized = false;

    protected string $summarizedBy = '';

    public function containerItemRelations() : array
    {
        return $this->containerItemRelations;
    }

    public function isSummarized() : bool
    {
        return $this->isSummarized;
    }

    public function summarizedBy() : string
    {
        return $this->summarizedBy;
    }
}
