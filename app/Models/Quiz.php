<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['subject_id', 'theme_id', 'title', 'description', 'time_limit'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
}
