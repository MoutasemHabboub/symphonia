<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCapable extends Model
{
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }public function job()
    {
        return $this->belongsTo(Job::class,'job_id');
    }
}
