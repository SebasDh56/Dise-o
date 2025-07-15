<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre', 'cedula', 'edad']; // Ajusta según tu esquema

    // Relación con las ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}