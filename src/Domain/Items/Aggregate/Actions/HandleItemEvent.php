<?php

namespace Psrearick\Containers\Domain\Items\Aggregate\Actions;

use Psrearick\Containers\Contracts\ItemEvent;

class HandleItemEvent
{
    public function execute(ItemEvent $event, string $actionName) : void
    {
        $model      = $event->item;
        $actions    = $model->actions();

        if (! isset($actions[$actionName])) {
            return;
        }

        foreach ($actions[$actionName] as $action) {
            if (! class_exists($action)) {
                continue;
            }

            if (! method_exists($action, 'execute')) {
                continue;
            }

            app($action)->execute($model);
        }
    }
}
