<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = ['nombre', 'correo', 'contra'];
    public function getAuthPassword()
    {
        return $this->contra;
    }
}