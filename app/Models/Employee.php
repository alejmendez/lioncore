<?php
namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends ModelBase
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'position',
        'group_id',
        'date_admission',
        'salary',
    ];

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }
}
