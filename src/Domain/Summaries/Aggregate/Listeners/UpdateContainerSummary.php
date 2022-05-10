<?php

namespace Psrearick\Containers\Domain\Summaries\Aggregate\Listeners;

use Psrearick\Containers\Domain\Containers\Aggregate\Events\ContainerItemWasSaved;

class UpdateContainerSummary
{
    public function handle(ContainerItemWasSaved $containerItemWasSaved) : void
    {
        ray($containerItemWasSaved->containerItem);
    }
}
