<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaAnimal extends Model
{
    protected $table = 'categorias_animales'; // Nombre de la tabla de categorías de animales

    protected $fillable = [
        'nombre', // Suponiendo que solo tiene un nombre
    ];

    public $timestamps = false; // Asumiendo que la tabla no tiene created_at ni updated_at

    // Relación inversa con los animales
    public function animales()
    {
        return $this->hasMany(Animal::class, 'categoria_id');
    }
}
