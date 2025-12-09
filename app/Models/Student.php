<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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

    
public function courses() {
    return $this->belongsToMany(Course::class);
}
public function grade()
{
    return $this->belongsTo(Grade::class);
}





}
