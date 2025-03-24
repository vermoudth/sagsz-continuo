<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    //use HasFactory;

    protected $table = 'animales'; // Nombre real en la base de datos

    protected $fillable = [
        'nombre',
        'especie',
        'raza',
        'edad',
        'peso',
        'ubicacion',
        'cuidador_id',
        'fecha_registro'
    ];

    public $timestamps = false; // Laravel no manejará created_at y updated_at automáticamente
}
