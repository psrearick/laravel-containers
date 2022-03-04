<?php

namespace Psrearick\Containers\Traits;

use Illuminate\Support\Str;

/**
 * @property string uuid
 */
trait HasUuid
{
    public static function bootHasUuid() : void
    {
        static::creating(static function ($model) {
            $model->uuid = $model->uuid ?: Str::uuid()->toString();
        });
    }

    public static function uuid(string $uuid) : ?self
    {
        return self::where('uuid', '=', $uuid)->first();
    }
}
