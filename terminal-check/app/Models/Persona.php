<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nombre',
        'cedula',
        'edad',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'persona_id');
    }
}