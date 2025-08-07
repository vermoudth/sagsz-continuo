<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CategoriaAnimal;

class RegistroAmbiental extends Model
{
    //use HasFactory;

    protected $table = 'registros_ambientales'; // Nombre real en la base de datos

    protected $fillable = [
        'categoria_id',
        'temperatura',
        'humedad',
        'registrado_en'
    ];

    public $timestamps = false; // Laravel no manejará created_at y updated_at automáticamente

    public function categoria()
    {
        return $this->belongsTo(CategoriaAnimal::class, 'categoria_id');  // La categoría del animal
    }
}