<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Student extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'reg_no',
        'name',
        'email',
        'ph_no',
        'dob',
        'class_id',
        
        'grade_id',
        'password',
        'profile_picture',

        'nic_front', 'nic_back'
    ];

    
public function courses()
{
    return $this->belongsToMany(Course::class, 'student_courses');
}

public function grades()
{
    return $this->belongsToMany(Grade::class, 'student_grades');
}





}
