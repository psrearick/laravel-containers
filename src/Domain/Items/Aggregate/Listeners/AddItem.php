<?php

namespace Psrearick\Containers\Domain\Items\Aggregate\Listeners;

use Psrearick\Containers\Domain\Items\Aggregate\Events\ItemWasCreated;

class AddItem
{
    public function handle(ItemWasCreated $event) : void
    {
        $model      = $event->item;
        $actions    = $model->actions();

        if (! isset($actions['created'])) {
            return;
        }

        foreach ($actions['created'] as $action) {
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
