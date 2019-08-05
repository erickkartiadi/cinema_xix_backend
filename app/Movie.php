<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function schedules(){
        return $this->hasMany('App\Schedule');
    }
}
