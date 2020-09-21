<?php
namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends ModelBase
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'value',
    ];

    public static function getProperty($name) {
        $value = self::where('name', $name)->first()->value;
        $value = json_decode($value);
        return collect($value);
    }
}
