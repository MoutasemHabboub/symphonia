<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    public $timestamps=false;

    protected $fillable = ['id' , 'address','name','students_gender','teaching_phase'];
    public function user()
    {
        return $this->belongsTo(User::class,'id');
    }
    
    public function teachIns()
    {
        return $this->hasMany(TeachIn::class,'school_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class,'school_id');
    }
    public function schoolRequests()
    {
        return $this->hasMany(SchoolRequest::class,'school_id');
    }
    public function phoneNumders()
    {
        return $this->hasMany(PhoneNumber::class,'school_id');
    }

}
