<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plane extends Model
{
    protected $fillable = [
        'tail_number'
    ];
        
    public function client(){
        return $this->belongsTo('App\Client');
    }

    public function dosas()
    {
        return $this->hasMany(Dosa::class);
    }
}
