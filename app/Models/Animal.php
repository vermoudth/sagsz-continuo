<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\CategoriaAnimal;

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

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaAnimal::class, 'categoria_id');  // La categoría del animal
    }
}
