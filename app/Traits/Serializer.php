<?php

namespace App\Traits;

use App\Models\Serial;
use Illuminate\Support\Str;

trait Serializer
{
    protected static function getSerial(array $options)
    {
        $collect = $options['collect'] ?? self::getTable();
        $prefix = $options['prefix'] ?? '';
        $length = $options['length'] ?? 5;
        $pad = $options['pad'] ?? 'left';
        $pad = strtolower($pad);

        $nextNumber = Serial::next($collect);
        $numberStr = $pad === 'left' ?
            Str::padLeft($nextNumber, $length, '0') :
            Str::padRight($nextNumber, $length, '0');

        return $prefix . $numberStr;
    }
}
