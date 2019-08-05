<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function movie(){
        return $this->belongsTo('App\Movie');
    }
    public function studio(){
        return $this->belongsTo('App\Studio');
    }
}
