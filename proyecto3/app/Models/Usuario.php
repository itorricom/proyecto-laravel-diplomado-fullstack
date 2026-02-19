<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        "id_persona",
        "id_rol",
        "username",
        "email",
        "clave_inicial",
        "password",
        "email_verified_at",
        "remember_token",
        "ultimo_acceso",
        "intentos_fallidos",
        "bloqueado_hasta",
        "debe_cambiar_password",
        "password_temporal",
        "estado"
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
