<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    protected $table = 'marcas';
    protected $primaryKey = 'id_marca';
    
    public $timestamps = false;

    protected $fillable = ['imagen', 'nombre', 'created_at','created_by'];

    public function autos()
    {
        return $this->hasMany(Auto::class, 'id_marca');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}