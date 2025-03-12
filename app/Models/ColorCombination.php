<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ColorCombination extends Model
{
    protected $fillable = ['name', 'colors', 'image_url'];

    protected $casts = [
        'colors' => 'array', // Convertir el campo `colors` a un array
    ];
}
