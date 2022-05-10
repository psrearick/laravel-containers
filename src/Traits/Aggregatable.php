<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Support\Facades\Event;
use Psrearick\Containers\Contracts\AggregateRoot;
use Psrearick\Containers\Contracts\Eventable;

trait Aggregatable
{
    protected ?AggregateRoot $root = null;

    public function root() : ?AggregateRoot
    {
        return $this->root;
    }

    protected static function bootAggregatable() : void
    {
        static::created(static function (Eventable $model) {
            if (! isset($model->events['created'])) {
                return;
            }

            foreach ($model->events['created'] as $event) {
                Event::dispatch(new $event($model));
            }
        });

        static::creating(static function (Eventable $model) {
            foreach ($model->aggregateAttributes() as $attribute) {
                if (! array_key_exists($attribute, $model->attributes)) {
                    continue;
                }

                $model->root()->$attribute = $model->$attribute;

                unset($model->$attribute);
            }

            if (! isset($model->events['creating'])) {
                return;
            }

            foreach ($model->events['creating'] as $event) {
                Event::dispatch(new $event($model));
            }
        });
    }

    protected function initializeAggregatable() : void
    {
        $this->setRoot();
    }

    protected function setRoot() : void
    {
        $this->root                     = app($this->classes('aggregateRoot'));
        $this->root->{$this->modelName} = $this;
    }
}
