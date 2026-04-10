<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function calculator()
    {
        return view('tools.calculator');
    }
}
