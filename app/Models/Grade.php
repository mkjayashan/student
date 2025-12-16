<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $fillable = ['grade_name', 'grade_code'];

    // A grade can have many classrooms
    public function classrooms() {
        return $this->hasMany(Classroom::class);
    }
    public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'teacher_grade'); // specify actual table
}
// App\Models\Grade.php

public function students()
{
    return $this->belongsToMany(Student::class, 'student_grades');
}


}
