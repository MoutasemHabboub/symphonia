<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $fillable = ['school_id' , 'phone_number'];

    public function school()
    {
        return $this->belongsTo(School::class,'school_id');
    }
}
