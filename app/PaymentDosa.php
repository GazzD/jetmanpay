<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentDosa extends Model
{
    public function payment()
    {
        return $this->belongsTo('App\Payment');
    }
}
