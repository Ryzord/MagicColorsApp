<?php

namespace App\Http\Controllers;

use App\Models\ColorCombination;
use Illuminate\Http\Request;

class ColorCombinationController extends Controller
{
    public function showByColors(Request $request)
    {
        $colors = $request->input('colors'); // Colores que el usuario ha seleccionado
        $combination = ColorCombination::whereJsonContains('colors', $colors)->first();

        if ($combination) {
            return response()->json([
                'name' => $combination->name,
                'colors' => $combination->colors,
            ]);
        }

        return response()->json(['error' => 'Combinación no encontrada.'], 404);
    }

    public function showByName(Request $request)
    {
        $name = $request->input('name'); // Nombre de la combinación
        $combination = ColorCombination::where('name', $name)->first();

        if ($combination) {
            return response()->json([
                'name' => $combination->name,
                'colors' => $combination->colors,
            ]);
        }

        return response()->json(['error' => 'Nombre no encontrado.'], 404);
    }
}
