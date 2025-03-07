<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorCombination extends Model
{
    protected $fillable = ['name', 'colors'];

    protected $casts = [
        'colors' => 'array', // Convertir el campo `colors` a un array
    ];
}
