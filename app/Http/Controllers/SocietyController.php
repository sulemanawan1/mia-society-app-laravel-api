<?php

namespace App\Http\Controllers;
use App\Models\Society;
use Illuminate\Http\Request;

class SocietyController extends Controller
{
    public function addsociety (Request $request)

    {
        $society = Society ::all();



return response()->json(["data"=> $society]);

    }
}
