<?php

namespace Psrearick\Containers\Services;

use Psrearick\Containers\Contracts\Container;
use Psrearick\Containers\Contracts\ContainerItem;
use Psrearick\Containers\Contracts\Item;

class ContainerItemManagerService
{
    public array $services = [];

    public function destroy() : void
    {
        $this->services = [];
    }

    public function service(Container $container, Item $item) : ContainerItemService
    {
        $found = null;
        foreach ($this->services as $service) {
            if ($service->is($container, $item)) {
                $found = $service;
            }
        }

        if (! $found) {
            $found            = app(ContainerItemService::class)->getInstance($container, $item);
            $this->services[] = $found;
        }

        return $found;
    }

    public function serviceFromContainerItem(ContainerItem $containerItem) : ContainerItemService
    {
        $found = null;
        foreach ($this->services as $service) {
            if ($service->isContainerItem($containerItem)) {
                $found = $service;
            }
        }

        if (! $found) {
            $found              = app(ContainerItemService::class)
                ->getInstanceFromContainerItem($containerItem);
            $this->services[]   = $found;
        }

        return $found;
    }
}
