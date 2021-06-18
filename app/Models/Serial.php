<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\AutoGenerateUuid;

class Serial extends Model
{
    use AutoGenerateUuid;
    protected $fillable = ['collect'];

    public static function next($collect)
    {
        $instance = self::firstOrCreate(['collect' => $collect], ['count' => 0]);
        $instance->increment('count');
        return $instance->count;
    }
}
