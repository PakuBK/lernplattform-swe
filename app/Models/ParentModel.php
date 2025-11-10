<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentModel extends Model
{
    use HasFactory;

    protected $table = 'parents';
    protected $fillable = ['user_id', 'phone'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->belongsToMany(Student::class, 'parent_child', 'parent_id', 'student_id');
    }
}
