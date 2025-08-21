<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objeto extends Model
{
    protected $table = 'objetos';

    protected $primaryKey = 'id_activo';

    public $timestamps = false;

    protected $fillable = [
        'codigo_activo',
        'nombre',
        'cantidad',
        'descripcion',
        'area',
        'ubicacion_fisica',
        'empleado_asignado',
        'estado',
        'observaciones',
    ];
}
