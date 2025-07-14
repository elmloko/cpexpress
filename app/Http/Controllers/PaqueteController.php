<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaqueteController extends Controller
{
    public function getAlmacen ()
    {
        return view('paquete.almacen');
    }
    public function getInventario ()
    {
        return view('paquete.inventario');
    }
    public function getRecibir ()
    {
        return view('paquete.recibir');
    }
    public function getEnviar ()
    {
        return view('paquete.enviar');
    }
    public function getDespacho ()
    {
        return view('paquete.despacho');
    }
        public function getTodos ()
    {
        return view('paquete.todos');
    }
}