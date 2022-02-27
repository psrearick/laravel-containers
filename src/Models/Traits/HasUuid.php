<?php

namespace Psrearick\Containers\Models\Traits;

use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUuid() : void
    {
        static::saving(static function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public static function uuid(string $uuid) : ?self
    {
        return self::where('uuid', '=', $uuid)->first();
    }
}
