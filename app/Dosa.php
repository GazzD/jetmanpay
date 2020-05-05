<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosa extends Model
{
    public function payments()
    {
        return $this->belongsToMany('App\Payment');
    }
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    public function plane()
    {
        return $this->belongsTo('App\Plane');
    }

    public function items(){
        return $this->hasMany('App\DosaItem');
    }
}
