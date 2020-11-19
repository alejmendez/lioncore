<?php
namespace App\Models;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registro extends ModelBase
{
    use SoftDeletes;

    protected $with = ['alumno'];

    protected $fillable = [
        'alumno_id',
        'title',
        'tutor',
        'consultancies',
        'documentation',
        'assignedDate',
        'presentation',
        'finalTome',
    ];

    public function alumno()
    {
        return $this->belongsTo('App\Models\Alumno');
    }
}
