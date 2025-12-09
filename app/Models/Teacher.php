<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Teacher extends Model
{
    use HasFactory;
      protected $fillable = [
        'reg_no',
        'teacher_name',
        'email',
        'nic',
        'address',
        'phone_no',
'grade_id',
'subject_id',
'profile_picture',
        'nic_front', 'nic_back'
        
    ];
    public function grades()
{
    return $this->belongsToMany(Grade::class, 'teacher_grade'); // specify actual table
}


public function subjects()
{
    return $this->belongsToMany(Subject::class, 'teacher_subjects'); // specify actual table
}



 
}
