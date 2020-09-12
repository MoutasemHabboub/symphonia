<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    
   public function jobCapables()
   {
       return $this->hasMany(JobCapable::class,'job_id');
   }
}
