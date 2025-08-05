<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaAnimal extends Model
{
    protected $table = 'categorias_animales'; // Nombre de la tabla de categorías de animales

    protected $fillable = [
        'nombre', // Solo tiene un nombre
    ];

    public $timestamps = false;

    // Relación inversa con los animales
    public function animales()
    {
        return $this->hasMany(Animal::class, 'categoria_id');
    }
}
