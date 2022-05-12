<?php

namespace Psrearick\Containers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Psrearick\Containers\Contracts\Summary;

class ContainerItemSummaryWasUpdated
{
    use Dispatchable;
    use SerializesModels;

    public Summary $summary;

    public function __construct(Summary $summary)
    {
        $this->summary = $summary;
    }
}
