<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeachIn extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
    public function school()
    {
        return $this->belongsTo(School::class,'school_id');
    }
}
