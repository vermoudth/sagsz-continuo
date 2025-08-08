<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traslados extends Model
{
    use HasFactory;

    protected $table = 'traslados';

    protected $fillable = [
        'id_animal',
        'origen',
        'destino',
        'fecha',
        'responsable_id',
    ];

     public $timestamps = false; // La tabla no tiene los campos created_at y updated_at

    // Relación con el modelo Animal
    public function animal()
    {
        return $this->belongsTo(Animal::class, 'id_animal');
    }

    // Relación con el modelo User (responsable)
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
