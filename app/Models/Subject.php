<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subject_name', 'subject_code'];
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_subject', 'subject_id', 'course_id');
    }

    use HasFactory;
}
