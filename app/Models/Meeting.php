<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Participation;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_name',
        'access_code',
        'status',
        'quiz_id',
        'user_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function participations()
    {
        return $this->hasMany(Participation::class);
    }
    
    public function students()
    {
        return $this->belongsToMany(User::class, 'participations')->withTimestamps()->withPivot('status');
    }
}
