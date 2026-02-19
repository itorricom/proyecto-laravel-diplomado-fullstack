<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'dni',
        'paterno',
        'materno',
        'nombre',
        'nombre_corto',
        'Website',
        'Twitter',
        'fecha_nacimiento',
        'direccion',
        'telefono_celular',
        'telefono_fijo',
        'zona',
        'email',
        'fotografia',
        'estado',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'id' => 'integer',
    ];

    protected $attributes = [
        'fotografia' => 'default.webp',
        'estado' => 'S',
    ];
}
