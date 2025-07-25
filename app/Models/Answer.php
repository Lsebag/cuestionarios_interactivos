<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
    'participation_id',
    'question_id',
    'option_id',
    ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function participation()
    {
        return $this->belongsTo(Participation::class);
    }
}
