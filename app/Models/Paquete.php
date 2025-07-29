<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paquete extends Model
{
    use SoftDeletes;

    protected $table = 'paquetes';

    protected $fillable = [
        'codigo',
        'destinatario',
        'estado',
        'cuidad',
        'precio',
        'origen',
        'destino',
        'aduana',
        'peso',
        'user',
        'observacion',
        'photo',
        'cantidad',
        'grupo',
        'almacenaje'
    ];

    protected $casts = [
        'peso' => 'float',
        'precio' => 'float',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
