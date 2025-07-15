<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'cooperativa_id',
        'persona_id',
        'cantidad_boletos',
        'precio_base',
        'comision',
        'fecha_venta',
    ];

    public function cooperativa()
    {
        return $this->belongsTo(Cooperativa::class, 'cooperativa_id');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
}