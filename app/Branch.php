<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    public function studios(){
        return $this->hasMany('App\Studio');
    }
}
