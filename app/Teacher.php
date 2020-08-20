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
}
