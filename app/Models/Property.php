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
}
