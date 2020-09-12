<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'phone_number', 'address','main_specialization',
        'cv','gender','berthday','nationality',
        'Baccalaureate_type','nationality','id'
   ];
   public function techingExperiences()
    {
        return $this->hasMany(TeachingExperience::class,'teacher_id');
    }
    public function teachIn()
    {
        return $this->hasMany(TeachIn::class,'teacher_id');
    }
    public function jobCapables()
   {
       return $this->hasMany(JobCapable::class,'teacher_id');
   }
   public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
}
