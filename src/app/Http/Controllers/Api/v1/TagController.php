<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function index()
    {
        // Retorna objetos com 'value' (nome) e 'color' para o Tagify
        $tags = Auth::user()->tags()
            ->select('name as value', 'color')
            ->distinct()
            ->get();

        return response()->json($tags);
    }
}
