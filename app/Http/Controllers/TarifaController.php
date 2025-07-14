<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function getTarifas ()
    {
        return view('tarifario.tarifa');
    }
    public function getEmpresas ()
    {
        return view('tarifario.empresa');
    }
    public function getPesos ()
    {
        return view('tarifario.peso');
    }
}