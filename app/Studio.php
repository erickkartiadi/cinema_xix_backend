<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    public function branch(){
        return $this->belongsTo('App\Branch');
    }
    public function schedules(){
        return $this->hasMany('App\Schedule');
    }
}
