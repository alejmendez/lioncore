<?php

namespace Modules\Core\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ModelBase extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function($model){
            $model->{$model->getKeyName()} = self::getUuid();
        });
    }

    protected static function getUuid()
    {
        return (string) Str::uuid();
    }
}
