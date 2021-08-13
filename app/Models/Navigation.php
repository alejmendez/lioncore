<?php
namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Navigation extends ModelBase
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'type',
        'tooltip',
        'link',
        'icon',
        'parent',
        'order',
        'meta',
    ];
}
