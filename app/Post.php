<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function school()
    {
        return $this->belongsTo(School::class,'school_id');
    }
}
