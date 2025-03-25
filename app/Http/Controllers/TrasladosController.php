<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrasladosController extends Controller
{
    public function index()
    {
        return view('interfaces.trasladosPanel');
    }
}
