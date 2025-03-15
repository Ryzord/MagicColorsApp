<?php

namespace App\Http\Controllers;

use App\Models\ColorCombination;
use Illuminate\Http\Request;

class ColorCombinationController extends Controller
{

    public function findByColors(Request $request)
    {
        $colors = $request->input('colors'); // Colors selected User
        // $name = $request->input('name');

        if (empty($colors)) {
            return response()->json(['error' => 'Por favor, selecciona al menos un color.'], 400);
        }

        $colors = array_map('ucfirst', $colors);
        $combination = ColorCombination::whereJsonContains('colors', $colors)->first();

        if ($combination) {
            $url = "images/combinations/" . $combination->name . ".png";

            return response()->json([
                'name' => $combination->name,
                'colors' => $combination->colors,
                'image_url' => $url
            ]);
        }

        return response()->json(['error' => 'Combinación no encontrada.'], 404);
    }

    public function findByName(Request $request)
    {
        $name = $request->input('name'); // Name of the combination
        $combination = ColorCombination::where('name', $name)->first();

        if ($combination) {
            $url = "images/combinations/" . $combination->name . ".png";

            return response()->json([
                'name' => $combination->name,
                'colors' => $combination->colors,
                'image_url' => $url
            ]);
        }

        return response()->json(['error' => 'Nombre no encontrado.'], 404);
    }
}
