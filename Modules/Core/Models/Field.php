<?php
namespace Modules\Core\Models;

use Modules\Core\Models\ModelBase;

class Field extends ModelBase
{
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function form()
    {
        return $this->belongsTo('Modules\Core\Models\Form');
    }
}
