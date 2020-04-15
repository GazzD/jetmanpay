<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dosa extends Model
{
    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
    
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    public function plane()
    {
        return $this->belongsTo('App\Plane');
    }
}
