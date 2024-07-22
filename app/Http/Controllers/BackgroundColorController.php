<?php

namespace App\Http\Controllers;

use App\Models\BackgroundColor;
use Illuminate\Http\Request;

class BackgroundColorController extends Controller
{
    public function get_all_backgroundcolor()
    {
        $backgroundcolors = BackgroundColor::all();
        return response()->json($backgroundcolors);
    }
}
