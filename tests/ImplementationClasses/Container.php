<?php

namespace Psrearick\Containers\Tests\ImplementationClasses;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Psrearick\Containers\Contracts\Container as ContainerContract;
use Psrearick\Containers\Database\Factories\ContainerFactory;
use Psrearick\Containers\Domain\Containers\Aggregate\ContainersAggregateRoot;
use Psrearick\Containers\Domain\Summaries\Models\ContainerSummary;
use Psrearick\Containers\Traits\Containerable;
use Psrearick\Containers\Traits\ContainerBaseActions;
use Psrearick\Containers\Traits\ContainerBaseAttributes;

/**
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $deleted_at
 */
class Container extends Model implements ContainerContract
{
    use Containerable;
    use ContainerBaseActions;
    use ContainerBaseAttributes;
    use hasFactory;

    protected function classes(string $key) : string
    {
        $classList = [
            'aggregateRoot'     => ContainersAggregateRoot::class,
            'containerItem'     => ContainerItem::class,
            'containerSummary'  => ContainerSummary::class,
        ];

        return $classList[$key] ?? '';
    }

    protected static function newFactory() : ContainerFactory
    {
        return ContainerFactory::new();
    }
}
