<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index()
    {
        return view('tasks');
    }
}
