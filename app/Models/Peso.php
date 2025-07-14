<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peso extends Model
{
    use SoftDeletes;

    protected $table = 'peso';

    protected $fillable = [
        'min',
        'max',
    ];

    protected $casts = [
        'min' => 'float',
        'max' => 'float',
    ];
}
