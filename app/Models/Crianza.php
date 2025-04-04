<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crianza extends Model
{
    use HasFactory;

    protected $table = 'crianza'; // Nombre exacto de la tabla en la BD

    protected $fillable = [
        'animal_id',
        'descripcion',
        'fecha',
        'responsable_id'
    ];

    public $timestamps = false; // La tabla no tiene los campos created_at y updated_at

    // Relación: Cada crianza pertenece a un animal
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    // Relación: Cada crianza tiene un responsable (usuario)
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}