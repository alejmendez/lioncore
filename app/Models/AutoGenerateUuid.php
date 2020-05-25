<?php

namespace Modules\Core\Models;

use Illuminate\Support\Str;

trait AutoGenerateUuid
{
    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = self::getUuid();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    protected static function getUuid()
    {
        return (string) Str::uuid();
    }
}
