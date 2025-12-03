<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_name', 'course_code'];
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'course_subject', 'course_id', 'subject_id');
    }
    use HasFactory;
}
