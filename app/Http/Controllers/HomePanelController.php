<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePanelController extends Controller
{
    public function index()
    {
        // $users = User::all(); //Ejemplo de cargar todos los usuarios
        return view('interfaces.homePanel');
    }
}
