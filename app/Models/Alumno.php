<?php
namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumno extends ModelBase
{
    use SoftDeletes;

    protected $fillable = [
        'firstName',
        'lastname',
        'phone',
        'email',
        'specialty',
        'semester',
    ];
}
