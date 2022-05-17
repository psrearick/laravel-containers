<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Psrearick\Containers\Computations\Subtract;
use Psrearick\Containers\Computations\Sum;
use Psrearick\Containers\Computations\Update;
use Psrearick\Containers\Models\ContainerItem as Base;

class ContainerOuter extends Base
{
    protected bool $isSingleton = true;

    public function computations() : array
    {
        return [
            Container::class => [
                'quantity' => [
                    'add'       => Sum::class,
                    'remove'    => Subtract::class,
                ],
                'value'     => [
                    'add'       => Update::class,
                    'remove'    => Update::class,
                ],
            ],
        ];
    }

    public function container() : BelongsTo
    {
        return $this->belongsTo(Outer::class, 'outer_id');
    }

    public function item() : BelongsTo
    {
        return $this->belongsTo(Container::class, 'container_id');
    }
}
