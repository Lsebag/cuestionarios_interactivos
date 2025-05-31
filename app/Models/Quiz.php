<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Relación: un cuestionario pertenece a un usuario (profesor)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relación: un cuestionario tiene muchas preguntas
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Relación: un cuestionario puede tener muchas sesiones
     */
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
