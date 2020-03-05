<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
    
    public function fees()
    {
        return $this->hasMany('App\PaymentFee');
    }
}
