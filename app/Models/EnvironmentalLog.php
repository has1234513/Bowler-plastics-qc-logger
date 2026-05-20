<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnvironmentalLog extends Model
{
    protected $fillable = [
        'batch_number',
        'temperature_celsius',
        'humidity_percent',
        'logged_at',
    ];

    protected function casts(): array
    {
        return [
            'logged_at' => 'datetime',
            'temperature_celsius' => 'decimal:2',
            'humidity_percent' => 'integer',
        ];
    }
}
