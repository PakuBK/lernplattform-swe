<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['theme_id', 'title', 'description', 'file_path'];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
