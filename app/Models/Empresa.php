<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = "empresas";
    // Los campos requeridos
    protected $fillable = [
        'cif', 'nombre', 'direccion','imagen' ,'telefono', 'email','cuentaBancaria', 'usuario_id', 'lista_eventos','isDeleted'
    ];

    public function scopeSearch($query, $name)
    {
        return $query->where('nombre', 'LIKE', "%$name%");
    }

    protected $casts = [
        'lista_eventos'=>'array'
    ];


}
