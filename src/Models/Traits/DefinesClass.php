<?php

namespace Psrearick\Containers\Models\Traits;

trait DefinesClass
{
    public static function bootDefinesClass() : void
    {
        static::saving(static function ($model) {
            $model->model = self::class;
        });
    }
}
