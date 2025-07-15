<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    protected $table = 'cooperativas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre',
        'cantidad_pasajeros',
        'porcentaje_comision',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'cooperativa_id');
    }
}