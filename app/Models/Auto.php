<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'autos';
    protected $primaryKey = 'id_auto';

    protected $fillable = [
        'id_marca', 'modelo', 'tipo', 'year', 'color', 'kilometraje', 
        'precio', 'transmision', 'combustible', 'created_at', 'created_by', 
        'descripcion', 'ocultar_kilometraje', 'consignacion'
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'id_marca');
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'id_auto');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'created_by');
    }
}