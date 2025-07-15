<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cooperativa extends Model
{
    protected $fillable = ['nombre', 'cantidad_pasajeros'];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}