<?php

namespace Psrearick\Containers\Traits;

trait DefinesClass
{
    public static function bootDefinesClass() : void
    {
        static::saving(static function ($model) {
            $model->model = get_class($model);
        });
    }
}
