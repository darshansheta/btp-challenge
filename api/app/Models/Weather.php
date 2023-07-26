<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $guarded =  ['id'];
    protected $table =  'weathers';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weather_array' => 'array',
        'calculated_at' => 'datetime',
        'sys_sunrise' => 'datetime',
        'sys_sunset' => 'datetime',
    ];
}
