<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable = ['class_name', 'grade_id'];

    // Classroom belongs to a grade
    public function grade() {
        return $this->belongsTo(Grade::class);
    }

     public function students()
    {
        return $this->hasMany(Student::class);
    }
    

}
