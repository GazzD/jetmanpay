<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    
    public function payments()
    {
        return $this->belongsToMany('App\Payment');
    }
}
