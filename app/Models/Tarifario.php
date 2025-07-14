<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarifario extends Model
{
    use SoftDeletes;

    protected $table = 'tarifario';

    protected $fillable = [
        'peso',
        'empresa',
        'local',
        'nacional',
        'camiri',
        'sud',
        'norte',
        'centro',
        'euro',
        'asia',
    ];

    protected $casts = [
        'peso'     => 'integer', // CAMBIADO DE float A integer
        'empresa'  => 'integer',
        'local'    => 'float',
        'nacional' => 'float',
        'camiri'   => 'float',
        'sud'      => 'float',
        'norte'    => 'float',
        'centro'   => 'float',
        'euro'     => 'float',
        'asia'     => 'float',
    ];

    public function empresaDatos()
    {
        return $this->belongsTo(Empresa::class, 'empresa');
    }

    public function pesoRango()
    {
        return $this->belongsTo(Peso::class, 'peso');
    }
}
