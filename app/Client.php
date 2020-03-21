<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nif', 'business_name', 'created_at', 'updated_at'
    ];
    public function payments()
    {
        return $this->belongsToMany('App\Payment');
    }
}
